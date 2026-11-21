import http from 'node:http';
import { exec } from 'node:child_process';

// Let's run chrome headless with remote debugging port 9222 and check console logs
const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const userData = 'C:\\Users\\galan\\AppData\\Local\\Temp\\chrome_test_' + Date.now();

const proc = exec(`"${chromePath}" --headless=new --remote-debugging-port=9333 --user-data-dir="${userData}" --no-first-run --no-default-browser-check https://kantin.radiantcode.web.id/login`);

setTimeout(async () => {
    try {
        const res = await fetch('http://127.0.0.1:9333/json');
        const list = await res.json();
        console.log('Tabs:', list);
        proc.kill();
    } catch (e) {
        console.error('Fetch error:', e.message);
        proc.kill();
    }
}, 3000);
