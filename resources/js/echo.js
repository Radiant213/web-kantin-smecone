import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

// Dynamic broadcaster selection based on environment
const broadcaster = import.meta.env.VITE_BROADCAST_CONNECTION || 'pusher';
const isDebugMode = import.meta.env.VITE_ECHO_DEBUG === 'true';

// Debug logging helper
function debugLog(message, data = null) {
    if (isDebugMode) {
        const timestamp = new Date().toISOString();
        console.log(`[Echo Debug ${timestamp}] ${message}`, data || '');
    }
}

// Validate environment variables
function validateEnvVars(broadcaster) {
    const errors = [];
    
    if (broadcaster === 'pusher') {
        if (!import.meta.env.VITE_PUSHER_APP_KEY) {
            errors.push('VITE_PUSHER_APP_KEY is not defined');
        }
        if (!import.meta.env.VITE_PUSHER_APP_CLUSTER) {
            errors.push('VITE_PUSHER_APP_CLUSTER is not defined');
        }
    } else if (broadcaster === 'reverb') {
        if (!import.meta.env.VITE_REVERB_APP_KEY) {
            errors.push('VITE_REVERB_APP_KEY is not defined');
        }
        if (!import.meta.env.VITE_REVERB_HOST) {
            errors.push('VITE_REVERB_HOST is not defined');
        }
    }
    
    return errors;
}

// Get configuration based on broadcaster type
function getEchoConfig(broadcaster) {
    if (broadcaster === 'reverb') {
        return {
            broadcaster: 'reverb',
            key: import.meta.env.VITE_REVERB_APP_KEY,
            wsHost: import.meta.env.VITE_REVERB_HOST,
            wsPort: import.meta.env.VITE_REVERB_PORT || 8080,
            wssPort: import.meta.env.VITE_REVERB_PORT || 8080,
            forceTLS: (import.meta.env.VITE_REVERB_SCHEME || 'https') === 'https',
            enabledTransports: ['ws', 'wss'],
        };
    } else {
        // Default to Pusher
        return {
            broadcaster: 'pusher',
            key: import.meta.env.VITE_PUSHER_APP_KEY,
            cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
            forceTLS: true,
        };
    }
}

// Initialize Echo with error handling and retry mechanism
let retryCount = 0;
const maxRetries = 3;
const retryDelay = 2000; // 2 seconds base delay

function initializeEcho() {
    try {
        debugLog('Initializing Echo', {
            broadcaster,
            hasKey: broadcaster === 'pusher' 
                ? !!import.meta.env.VITE_PUSHER_APP_KEY 
                : !!import.meta.env.VITE_REVERB_APP_KEY,
            retryCount,
        });
        
        // Validate environment variables
        const validationErrors = validateEnvVars(broadcaster);
        if (validationErrors.length > 0) {
            const errorMessage = `Echo initialization failed: Missing environment variables:\n${validationErrors.join('\n')}`;
            console.error(errorMessage);
            console.error('Please check your .env file and ensure all required VITE_* variables are defined.');
            console.error('For Pusher: VITE_PUSHER_APP_KEY, VITE_PUSHER_APP_CLUSTER');
            console.error('For Reverb: VITE_REVERB_APP_KEY, VITE_REVERB_HOST');
            return;
        }
        
        // Get configuration
        const config = getEchoConfig(broadcaster);
        debugLog('Echo configuration', config);
        
        // Initialize Echo
        window.Echo = new Echo(config);
        
        debugLog('Echo initialized successfully');
        
        // Add connection event listeners
        if (window.Echo.connector && window.Echo.connector.pusher) {
            const connection = window.Echo.connector.pusher.connection;
            
            connection.bind('connected', () => {
                debugLog('WebSocket connected');
                retryCount = 0; // Reset retry count on successful connection
            });
            
            connection.bind('disconnected', () => {
                debugLog('WebSocket disconnected');
            });
            
            connection.bind('error', (error) => {
                console.error('WebSocket connection error:', error);
                debugLog('WebSocket error', error);
                
                // Retry connection with exponential backoff
                if (retryCount < maxRetries) {
                    retryCount++;
                    const delay = retryDelay * Math.pow(2, retryCount - 1);
                    console.log(`Retrying connection in ${delay}ms (attempt ${retryCount}/${maxRetries})...`);
                    debugLog(`Scheduling retry`, { attempt: retryCount, delay });
                    
                    setTimeout(() => {
                        debugLog('Attempting reconnection');
                        window.Echo.connector.pusher.connect();
                    }, delay);
                } else {
                    console.error('Max retry attempts reached. Please check your WebSocket configuration.');
                    debugLog('Max retries reached', { maxRetries });
                }
            });
            
            connection.bind('state_change', (states) => {
                debugLog('Connection state change', {
                    previous: states.previous,
                    current: states.current,
                });
            });
        }
        
    } catch (error) {
        console.error('Failed to initialize Echo:', error);
        console.error('Broadcaster:', broadcaster);
        console.error('Please check your .env configuration and ensure the WebSocket server is running.');
        debugLog('Initialization error', error);
    }
}

// Initialize Echo
initializeEcho();
