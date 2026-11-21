import { exec } from 'node:child_process';

const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const userData = 'C:\\Users\\galan\\AppData\\Local\\Temp\\chrome_cdp_' + Date.now();

const proc = exec(`"${chromePath}" --headless=new --remote-debugging-port=9444 --user-data-dir="${userData}" --no-first-run --no-default-browser-check https://kantin.radiantcode.web.id/login`);

async function run() {
    await new Promise(r => setTimeout(r, 2000));
    const tabsRes = await fetch('http://127.0.0.1:9444/json');
    const tabs = await tabsRes.json();
    const pageTab = tabs.find(t => t.type === 'page');
    console.log('Page tab WS URL:', pageTab.webSocketDebuggerUrl);

    const ws = new WebSocket(pageTab.webSocketDebuggerUrl);
    let id = 1;
    const callbacks = new Map();

    function send(method, params = {}) {
        return new Promise((resolve, reject) => {
            const reqId = id++;
            callbacks.set(reqId, resolve);
            ws.send(JSON.stringify({ id: reqId, method, params }));
        });
    }

    ws.onmessage = (event) => {
        const msg = JSON.parse(event.data);
        if (msg.method === 'Runtime.consoleAPICalled') {
            console.log('[BROWSER CONSOLE]', msg.params.type, ...msg.params.args.map(a => a.value || a.description));
        }
        if (msg.method === 'Runtime.exceptionThrown') {
            console.error('[BROWSER EXCEPTION]', msg.params.exceptionDetails);
        }
        if (msg.id && callbacks.has(msg.id)) {
            callbacks.get(msg.id)(msg.result);
            callbacks.delete(msg.id);
        }
    };

    await new Promise(r => ws.onopen = r);
    await send('Runtime.enable');
    await send('Page.enable');

    console.log('Filling login form...');
    await send('Runtime.evaluate', {
        expression: `
            document.querySelector('input[name="email"]').value = 'admin@smecone.sch.id';
            document.querySelector('input[name="password"]').value = 'password';
            document.querySelector('form').submit();
        `
    });

    await new Promise(r => setTimeout(r, 2500));

    // Now evaluate on /admin
    const evalRes = await send('Runtime.evaluate', {
        expression: `
            (() => {
                const btn = document.getElementById('admin-user-btn');
                const menu = document.getElementById('admin-user-menu');
                const rect = btn ? btn.getBoundingClientRect() : null;
                const elAtCenter = rect ? document.elementFromPoint(rect.x + rect.width / 2, rect.y + rect.height / 2) : null;
                
                return {
                    url: window.location.href,
                    btnFound: !!btn,
                    menuFound: !!menu,
                    btnRect: rect ? { x: rect.x, y: rect.y, w: rect.width, h: rect.height } : null,
                    elementUnderMouse: elAtCenter ? (elAtCenter.tagName + '.' + elAtCenter.className + '#' + elAtCenter.id) : null,
                    isBtnCovered: elAtCenter && !btn.contains(elAtCenter),
                    panelDesktopDisplay: document.getElementById('admin-right-panel-desktop')?.style.display,
                    panelDesktopClass: document.getElementById('admin-right-panel-desktop')?.className,
                };
            })()
        `,
        returnByValue: true
    });

    console.log('EVAL RESULT:', JSON.stringify(evalRes, null, 2));

    // Try clicking button
    console.log('Testing click on #admin-user-btn...');
    const clickRes = await send('Runtime.evaluate', {
        expression: `
            (() => {
                const btn = document.getElementById('admin-user-btn');
                const menu = document.getElementById('admin-user-menu');
                btn.click();
                return {
                    menuDisplayAfterClick: menu.style.display,
                    menuClassAfterClick: menu.className,
                    menuVisibleComputed: window.getComputedStyle(menu).display
                };
            })()
        `,
        returnByValue: true
    });

    console.log('CLICK RESULT:', JSON.stringify(clickRes, null, 2));

    ws.close();
    proc.kill();
    process.exit(0);
}

run().catch(e => {
    console.error('Test error:', e);
    proc.kill();
    process.exit(1);
});
