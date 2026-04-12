import './bootstrap';

import Alpine from 'alpinejs';
import { inject } from '@vercel/analytics';

window.Alpine = Alpine;

Alpine.start();

// Initialize Vercel Web Analytics
inject();

// Initialize Vercel Speed Insights
import { injectSpeedInsights } from '@vercel/speed-insights';
injectSpeedInsights();
