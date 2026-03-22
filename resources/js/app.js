import './bootstrap';

import Alpine from 'alpinejs';
import { inject } from '@vercel/analytics';

window.Alpine = Alpine;

Alpine.start();

// Initialize Vercel Web Analytics
inject({
    mode: import.meta.env.MODE === 'production' ? 'production' : 'development',
    debug: import.meta.env.MODE === 'development'
});
