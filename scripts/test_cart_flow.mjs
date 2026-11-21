async function testCart() {
  const baseUrl = 'https://kantin.radiantcode.web.id';
  let cookies = {};

  function parseCookies(res) {
    const raw = res.headers.getSetCookie ? res.headers.getSetCookie() : [res.headers.get('set-cookie')];
    if (raw) {
      for (const str of raw) {
        if (!str) continue;
        const part = str.split(';')[0];
        const [k, v] = part.split('=');
        if (k && v) cookies[k.trim()] = v.trim();
      }
    }
  }

  function getCookieHeader() {
    return Object.entries(cookies).map(([k, v]) => `${k}=${v}`).join('; ');
  }

  console.log('1. Fetching login page...');
  const loginRes = await fetch(baseUrl + '/login');
  parseCookies(loginRes);
  const loginHtml = await loginRes.text();
  const tokenMatch = loginHtml.match(/name="_token"\s+value="([^"]+)"/);
  const token = tokenMatch ? tokenMatch[1] : null;

  console.log('2. Logging in as siswa@kantin.test...');
  const loginParams = new URLSearchParams();
  loginParams.append('_token', token);
  loginParams.append('email', 'siswa@kantin.test');
  loginParams.append('password', 'password');

  const doLogin = await fetch(baseUrl + '/login', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
      'Cookie': getCookieHeader()
    },
    body: loginParams.toString(),
    redirect: 'manual'
  });
  parseCookies(doLogin);

  console.log('3. Getting Kiosk 9 (Stand 2 - Cimol)...');
  const kioskRes = await fetch(baseUrl + '/kiosk/9', {
    headers: { 'Cookie': getCookieHeader() }
  });
  const kioskHtml = await kioskRes.text();
  const tokenMatch2 = kioskHtml.match(/name="_token"\s+value="([^"]+)"/);
  const token2 = tokenMatch2 ? tokenMatch2[1] : token;

  const cimolIdMatch = kioskHtml.match(/openCimolModal\((\d+)/);
  const cimolId = cimolIdMatch ? cimolIdMatch[1] : '74';

  console.log('4. Adding customized Cimol (Rp 3.000, Balado & Asin)...');
  const cimolParams = new URLSearchParams();
  cimolParams.append('_token', token2);
  cimolParams.append('menu_id', cimolId);
  cimolParams.append('quantity', '1');
  cimolParams.append('custom_price', '3000');
  cimolParams.append('notes', 'Porsi: Rp 3.000 | Bumbu: Balado, Asin / Gurih | Catatan: bumbu banyakin');

  const addCimol = await fetch(baseUrl + '/cart/add', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
      'Cookie': getCookieHeader()
    },
    body: cimolParams.toString(),
    redirect: 'manual'
  });
  parseCookies(addCimol);

  console.log('5. Adding customized Seblak (Rp 10.000, Level 2 + Mie + Telur)...');
  const seblakParams = new URLSearchParams();
  seblakParams.append('_token', token2);
  seblakParams.append('menu_id', '53');
  seblakParams.append('quantity', '1');
  seblakParams.append('custom_price', '10000');
  seblakParams.append('notes', 'Level 2 (Pedas Nampol) | Topping: Mie Kuning, Telur Kocok | Catatan: kuah nyemek');

  const addSeblak = await fetch(baseUrl + '/cart/add', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
      'Cookie': getCookieHeader()
    },
    body: seblakParams.toString(),
    redirect: 'manual'
  });
  parseCookies(addSeblak);

  console.log('6. Checking Baki Keranjang (/cart)...');
  const cartRes = await fetch(baseUrl + '/cart', {
    headers: { 'Cookie': getCookieHeader() }
  });
  const cartHtml = await cartRes.text();
  const tokenMatch3 = cartHtml.match(/name="_token"\s+value="([^"]+)"/);
  const token3 = tokenMatch3 ? tokenMatch3[1] : token2;

  console.log('7. Performing Checkout...');
  const checkoutParams = new URLSearchParams();
  checkoutParams.append('_token', token3);
  checkoutParams.append('pickup_session', 'istirahat_1');
  checkoutParams.append('notes', 'Tolong jangan terlalu lama disajikan ya');

  const doCheckout = await fetch(baseUrl + '/cart/checkout', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
      'Cookie': getCookieHeader()
    },
    body: checkoutParams.toString(),
    redirect: 'manual'
  });
  parseCookies(doCheckout);
  console.log('Checkout status:', doCheckout.status, 'redirect:', doCheckout.headers.get('location'));

  console.log('8. Checking Orders list (/orders)...');
  const ordersRes = await fetch(baseUrl + '/orders', {
    headers: { 'Cookie': getCookieHeader() }
  });
  const ordersHtml = await ordersRes.text();

  console.log('\n================ VERIFIKASI PESANAN SISWA ================');
  console.log('✓ Halaman pesanan memuat Cimol:', ordersHtml.includes('Cimol Goreng Gurih'));
  console.log('✓ Catatan bumbu Cimol tertera di rincian pesanan:', ordersHtml.includes('Balado, Asin / Gurih'));
  console.log('✓ Halaman pesanan memuat Seblak:', ordersHtml.includes('Seblak Khas Bandung'));
  console.log('✓ Catatan topping Seblak tertera di rincian pesanan:', ordersHtml.includes('Mie Kuning, Telur Kocok'));
  console.log('✓ Tombol Bayar QRIS muncul:', ordersHtml.includes('Bayar QRIS'));
  console.log('==========================================================\n');
}

testCart().catch(err => console.error(err));

async function testSellerView() {
  const baseUrl = 'https://kantin.radiantcode.web.id';
  let cookies = {};
  function parseCookies(res) {
    const raw = res.headers.getSetCookie ? res.headers.getSetCookie() : [res.headers.get('set-cookie')];
    if (raw) {
      for (const str of raw) {
        if (!str) continue;
        const part = str.split(';')[0];
        const [k, v] = part.split('=');
        if (k && v) cookies[k.trim()] = v.trim();
      }
    }
  }
  function getCookieHeader() {
    return Object.entries(cookies).map(([k, v]) => `${k}=${v}`).join('; ');
  }

  console.log('\n9. Testing Seller Kitchen View (Tante Mita)...');
  const loginRes = await fetch(baseUrl + '/login');
  parseCookies(loginRes);
  const loginHtml = await loginRes.text();
  const token = loginHtml.match(/name="_token"\s+value="([^"]+)"/)[1];

  const loginParams = new URLSearchParams();
  loginParams.append('_token', token);
  loginParams.append('email', 'tantemita@kantin.smecone');
  loginParams.append('password', 'password');

  const doLogin = await fetch(baseUrl + '/login', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'Cookie': getCookieHeader() },
    body: loginParams.toString(),
    redirect: 'manual'
  });
  parseCookies(doLogin);

  const ordersRes = await fetch(baseUrl + '/penjual/orders', {
    headers: { 'Cookie': getCookieHeader() }
  });
  const html = await ordersRes.text();
  console.log('✓ Penjual Orders Status:', ordersRes.status);
  console.log('✓ Seblak tampil di dapur penjual:', html.includes('Seblak Khas Bandung'));
  console.log('✓ Topping Mie & Telur terbaca oleh penjual:', html.includes('Mie Kuning, Telur Kocok'));
  console.log('✓ Request kuah nyemek terbaca:', html.includes('kuah nyemek'));
}

testSellerView().catch(e => console.error(e));
