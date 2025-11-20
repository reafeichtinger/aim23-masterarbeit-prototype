import '@fontsource-variable/lexend-deca';
import './grapes.js';

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

/* 
 * Global Alpine Data
 */

document.addEventListener('alpine:init', () => {
    // Countdown
    Alpine.data('countdown', (expiresData) => ({
        seconds: '00',
        minutes: '00',
        difference: 0,
        countdown: null,
        expires: new Date(expiresData).getTime(),
        now: new Date().getTime(),
        init() {
            this.updateTime();
            this.start();
        },
        start() {
            this.countdown = setInterval(() => this.updateTime(), 1000);
        },
        updateTime() {
            this.now = new Date().getTime();
            this.difference = this.expires - this.now;

            this.minutes = String(Math.abs(Math.ceil((this.difference % (1000 * 60 * 60)) / (1000 * 60)))).padStart(2, '0');
            this.seconds = String(Math.abs(Math.ceil((this.difference % (1000 * 60)) / 1000))).padStart(2, '0');

            if (this.difference == 0) {
                clearInterval(this.countdown);
                // this.days = '00';
                // this.hours = '00';
                this.minutes = '00';
                this.seconds = '00';
            }
        },
    }));
});

Livewire.start();

import 'ckeditor5-livewire';