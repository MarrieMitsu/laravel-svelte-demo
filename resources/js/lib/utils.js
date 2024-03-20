/**
 * Simple uid
 *
 * @returns
 */
export function uid() {
    return Date.now().toString(36) + Math.random().toString(36).substring(2, 12).padStart(12, 0);
}
