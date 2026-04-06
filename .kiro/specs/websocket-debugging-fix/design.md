# WebSocket Debugging Fix Design

## Overview

This bugfix addresses critical WebSocket configuration issues in the E-Kantin system. The primary issue is Vite environment variables not loading correctly, causing "Uncaught You must pass your app key when you instantiate Pusher" error. The fix implements a dual-broadcaster strategy (Reverb for development, Pusher for production) with comprehensive error handling, debugging tools, and documentation. The solution ensures minimal code changes while adding robust logging and fallback mechanisms.

## Glossary

- **Bug_Condition (C)**: The condition that triggers WebSocket failures - when Vite environment variables are undefined or broadcaster configuration is incorrect
- **Property (P)**: The desired behavior - WebSocket connections establish successfully with proper error handling and logging
- **Preservation**: Existing event broadcasting behavior (OrderMasuk, OrderStatusUpdated) and channel authorization must remain unchanged
- **Echo**: Laravel Echo client library that manages WebSocket connections in the frontend
- **Broadcaster**: The WebSocket service provider (Pusher or Reverb) used for real-time communication
- **Reverb**: Laravel's first-party WebSocket server for development environments
- **Pusher**: Third-party WebSocket service for production deployments
- **VITE_* variables**: Environment variables exposed to the frontend via Vite's import.meta.env

## Bug Details

### Bug Condition

The bug manifests when the application attempts to initialize Laravel Echo with undefined environment variables. The `echo.js` file reads `import.meta.env.VITE_PUSHER_APP_KEY` which is undefined because Vite is not loading environment variables from `.env`. Additionally, there's no error handling when WebSocket connections fail, no logging for debugging, and inconsistent configuration between `.env` (Pusher) and `.env.example` (Reverb).

**Formal Specification:**
```
FUNCTION isBugCondition(input)
  INPUT: input of type EchoInitializationContext
  OUTPUT: boolean
  
  RETURN (input.viteEnvVars.VITE_PUSHER_APP_KEY === undefined 
          OR input.viteEnvVars.VITE_REVERB_APP_KEY === undefined)
         AND input.broadcasterType IN ['pusher', 'reverb']
         AND NOT echoConnectionEstablished(input)
         AND NOT errorHandlingPresent(input)
END FUNCTION
```

### Examples

- **Example 1**: Developer runs `npm run dev` → Vite loads but `import.meta.env.VITE_PUSHER_APP_KEY` is undefined → Echo initialization fails with "You must pass your app key" error → No WebSocket connection established
  - Expected: Vite should load `VITE_PUSHER_APP_KEY` from `.env` and Echo should initialize successfully OR use Reverb for development

- **Example 2**: `.env` has `BROADCAST_CONNECTION=pusher` with Pusher credentials → Frontend tries to connect to Pusher → Network error occurs → No error logged, user sees no feedback
  - Expected: Error should be caught, logged to console with details, and user should see informative message

- **Example 3**: Developer switches from Pusher to Reverb → Changes `.env` to `BROADCAST_CONNECTION=reverb` → Frontend still uses hardcoded `broadcaster: 'pusher'` in `echo.js` → Connection fails
  - Expected: Frontend should read broadcaster type from environment variable and use appropriate configuration

- **Edge Case**: Reverb server not running → Echo tries to connect → Connection timeout → No retry mechanism, no logging
  - Expected: System should retry with exponential backoff and log each attempt with timestamp

## Expected Behavior

### Preservation Requirements

**Unchanged Behaviors:**
- Event broadcasting for `OrderMasuk` to channel `kios.{kioskId}` must continue to work exactly as before
- Event broadcasting for `OrderStatusUpdated` to channel `user.{userId}` must continue to work exactly as before
- Channel authorization in `routes/channels.php` must remain unchanged
- Audio notification playback and modal display on OrderMasuk must continue to work
- Web Push notifications via `WebPushService` must remain independent and functional
- `ShouldBroadcastNow` synchronous broadcasting behavior must be preserved
- 403 Forbidden responses for unauthorized channel access must continue

**Scope:**
All inputs that do NOT involve WebSocket initialization or connection establishment should be completely unaffected by this fix. This includes:
- Backend event dispatching logic (`OrderMasuk`, `OrderStatusUpdated`)
- Channel authorization callbacks
- Web Push notification system
- Frontend event listeners (`.listen('OrderMasuk')`, `.listen('OrderStatusUpdated')`)
- Audio playback and UI updates triggered by events

## Hypothesized Root Cause

Based on the bug description and code analysis, the most likely issues are:

1. **Vite Environment Variable Loading**: Vite requires explicit configuration to load environment variables starting with `VITE_` prefix. The current `vite.config.js` does not have any special configuration, so Vite should automatically load `VITE_*` variables from `.env`. However, the `.env` file uses variable interpolation (`VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"`) which may not work correctly in all Vite versions or requires the server to be restarted after `.env` changes.

2. **Hardcoded Broadcaster Type**: The `echo.js` file has `broadcaster: 'pusher'` hardcoded, preventing dynamic switching between Reverb (development) and Pusher (production) based on environment.

3. **Missing Error Handling**: No try-catch blocks around Echo initialization, no connection error listeners, no logging when connections fail.

4. **Configuration Inconsistency**: `.env` uses Pusher configuration while `.env.example` recommends Reverb, causing confusion during setup and deployment.

## Correctness Properties

Property 1: Bug Condition - WebSocket Connection Establishment

_For any_ application initialization where environment variables are properly configured and the broadcaster service is available, the fixed Echo initialization SHALL successfully establish a WebSocket connection, log the connection status, and enable real-time event listening without throwing errors.

**Validates: Requirements 2.1, 2.2, 2.3, 2.4**

Property 2: Preservation - Event Broadcasting Behavior

_For any_ event broadcast (OrderMasuk, OrderStatusUpdated) that was working before the fix, the fixed code SHALL produce exactly the same broadcasting behavior, delivering events to the same channels with the same payload structure, preserving all existing functionality for event dispatching and listening.

**Validates: Requirements 3.1, 3.2, 3.3, 3.4, 3.5, 3.6, 3.7, 3.8**

## Fix Implementation

### Changes Required

Assuming our root cause analysis is correct:

**File**: `resources/js/echo.js`

**Function**: Echo initialization

**Specific Changes**:
1. **Dynamic Broadcaster Selection**: Read broadcaster type from `import.meta.env.VITE_BROADCAST_CONNECTION` and conditionally initialize Echo with Pusher or Reverb configuration
   - Add environment variable check: `const broadcaster = import.meta.env.VITE_BROADCAST_CONNECTION || 'pusher'`
   - Create separate configuration objects for Pusher and Reverb
   - Use conditional logic to select appropriate configuration

2. **Environment Variable Validation**: Add validation to check if required environment variables are defined before initializing Echo
   - Check if `VITE_PUSHER_APP_KEY` is defined when using Pusher
   - Check if `VITE_REVERB_APP_KEY` is defined when using Reverb
   - Log clear error messages if variables are missing

3. **Error Handling**: Wrap Echo initialization in try-catch block and add connection error listeners
   - Catch initialization errors and log to console with details
   - Add `error` event listener to Echo connection
   - Add `disconnected` event listener to track connection state

4. **Debug Logging**: Add optional debug mode that logs connection status, channel subscriptions, and events
   - Check `import.meta.env.VITE_ECHO_DEBUG` flag
   - Log broadcaster type, credentials status (present/missing), and connection attempts
   - Log successful channel subscriptions and received events

5. **Retry Mechanism**: Implement exponential backoff for connection retries
   - Track retry attempts and delay between retries
   - Log each retry attempt with timestamp
   - Set maximum retry limit to prevent infinite loops

**File**: `vite.config.js`

**Configuration**: Environment variable loading

**Specific Changes**:
1. **Explicit Environment Variable Definition**: Add `define` option to explicitly expose environment variables to the frontend
   - Define `VITE_BROADCAST_CONNECTION`, `VITE_PUSHER_APP_KEY`, `VITE_PUSHER_APP_CLUSTER`, `VITE_REVERB_APP_KEY`, `VITE_REVERB_HOST`, `VITE_REVERB_PORT`, `VITE_REVERB_SCHEME`
   - Use `process.env` to read from `.env` file
   - This ensures variables are available even if interpolation fails

**File**: `.env`

**Configuration**: Development environment setup

**Specific Changes**:
1. **Switch to Reverb for Development**: Change `BROADCAST_CONNECTION=reverb` and add Reverb credentials
   - Set `BROADCAST_CONNECTION=reverb`
   - Add `REVERB_APP_ID`, `REVERB_APP_KEY`, `REVERB_APP_SECRET`, `REVERB_HOST`, `REVERB_PORT`, `REVERB_SCHEME`
   - Add `VITE_BROADCAST_CONNECTION=reverb` for frontend
   - Keep Pusher credentials commented out for production reference

2. **Add Debug Flag**: Add `VITE_ECHO_DEBUG=true` for development logging

**File**: `app/Events/OrderMasuk.php` and `app/Events/OrderStatusUpdated.php`

**Function**: Event broadcasting

**Specific Changes**:
1. **Add Backend Logging**: Log when events are broadcast for debugging purposes
   - Add `\Log::info()` call in constructor or `broadcastOn()` method
   - Log event name, channel, and payload summary (order ID, status)
   - Only log in development environment to avoid production log bloat

**File**: `.kiro/specs/websocket-debugging-fix/WEBSOCKET_SETUP.md` (new file)

**Documentation**: Setup and troubleshooting guide

**Specific Changes**:
1. **Create Comprehensive Documentation**: Document setup for both Reverb (development) and Pusher (production)
   - Installation steps for Reverb server
   - Configuration guide for `.env` variables
   - Troubleshooting section for common errors ("app key" error, connection failures)
   - Testing procedures to verify WebSocket functionality
   - Switching between Reverb and Pusher for different environments

## Testing Strategy

### Validation Approach

The testing strategy follows a two-phase approach: first, surface counterexamples that demonstrate the bug on unfixed code, then verify the fix works correctly and preserves existing behavior. Testing will be primarily manual and integration-based due to the nature of WebSocket connections requiring real server infrastructure.

### Exploratory Bug Condition Checking

**Goal**: Surface counterexamples that demonstrate the bug BEFORE implementing the fix. Confirm or refute the root cause analysis. If we refute, we will need to re-hypothesize.

**Test Plan**: Run the application with the UNFIXED code and observe the browser console for errors. Test with different `.env` configurations (missing variables, Pusher vs Reverb) to identify all failure modes.

**Test Cases**:
1. **Missing Environment Variables Test**: Remove `VITE_PUSHER_APP_KEY` from `.env` and run `npm run dev` (will fail on unfixed code with "You must pass your app key" error)
2. **Variable Interpolation Test**: Use `VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"` syntax and check if Vite loads it correctly (may fail if interpolation not supported)
3. **Broadcaster Mismatch Test**: Set `.env` to `BROADCAST_CONNECTION=reverb` but keep `echo.js` hardcoded to `pusher` (will fail with connection error)
4. **Network Failure Test**: Configure Pusher credentials but disconnect network (will fail silently with no error logging)

**Expected Counterexamples**:
- Console error: "Uncaught You must pass your app key when you instantiate Pusher"
- `import.meta.env.VITE_PUSHER_APP_KEY` returns undefined in browser console
- No error messages when WebSocket connection fails
- Possible causes: Vite not loading variables, variable interpolation failing, missing error handling

### Fix Checking

**Goal**: Verify that for all inputs where the bug condition holds, the fixed function produces the expected behavior.

**Pseudocode:**
```
FOR ALL config WHERE isBugCondition(config) DO
  result := initializeEcho_fixed(config)
  ASSERT connectionEstablished(result) OR errorLogged(result)
  ASSERT environmentVariablesLoaded(config)
  ASSERT broadcasterMatchesConfig(result, config)
END FOR
```

**Test Cases**:
1. **Reverb Development Setup**: Configure `.env` for Reverb, start Reverb server, verify Echo connects successfully
2. **Pusher Production Setup**: Configure `.env` for Pusher, verify Echo connects to Pusher successfully
3. **Debug Logging**: Enable `VITE_ECHO_DEBUG=true`, verify connection logs appear in console
4. **Error Handling**: Misconfigure credentials, verify error is caught and logged with helpful message
5. **Retry Mechanism**: Stop Reverb server after connection, verify retry attempts are logged

### Preservation Checking

**Goal**: Verify that for all inputs where the bug condition does NOT hold, the fixed function produces the same result as the original function.

**Pseudocode:**
```
FOR ALL event WHERE NOT isBugCondition(event) DO
  ASSERT broadcastEvent_original(event) = broadcastEvent_fixed(event)
  ASSERT channelAuthorization_original(event) = channelAuthorization_fixed(event)
  ASSERT eventListeners_original(event) = eventListeners_fixed(event)
END FOR
```

**Testing Approach**: Property-based testing is NOT recommended for preservation checking in this case because WebSocket behavior requires real infrastructure and cannot be easily mocked. Instead, manual integration testing with real Reverb/Pusher servers is more appropriate.

**Test Plan**: Observe behavior on UNFIXED code first for event broadcasting and listening, then verify the same behavior continues after the fix.

**Test Cases**:
1. **OrderMasuk Broadcasting**: Create a new order, verify `OrderMasuk` event is broadcast to `kios.{kioskId}` channel with same payload structure
2. **OrderStatusUpdated Broadcasting**: Update order status, verify `OrderStatusUpdated` event is broadcast to `user.{userId}` channel with same payload
3. **Audio Notification**: Verify audio notification plays when OrderMasuk is received (same as before fix)
4. **Channel Authorization**: Verify unauthorized users still receive 403 when trying to subscribe to channels they don't own
5. **Web Push Independence**: Verify Web Push notifications continue to work independently of WebSocket fix

### Unit Tests

- Test environment variable validation logic (check if variables are defined)
- Test broadcaster selection logic (Pusher vs Reverb based on config)
- Test error message formatting for missing credentials
- Test retry delay calculation (exponential backoff)

### Property-Based Tests

Property-based testing is NOT applicable for this bugfix because:
- WebSocket connections require real server infrastructure (Reverb or Pusher)
- Connection behavior is non-deterministic (network latency, server availability)
- Event broadcasting involves database state and authentication
- Mocking WebSocket behavior would not provide meaningful test coverage

### Integration Tests

- Test full order creation flow with WebSocket notifications in development (Reverb)
- Test full order status update flow with WebSocket notifications in production (Pusher)
- Test switching between Reverb and Pusher by changing `.env` configuration
- Test connection recovery when Reverb server is restarted
- Test that visual feedback (modal, audio) occurs when events are received
- Test channel authorization with different user roles (admin, penjual, pembeli)
