class BarcodeScanner {
    timeoutHandler = 0
    inputString = ''

    initialize = () => {
        document.addEventListener('keypress', this.keypress)
        if (this.timeoutHandler) {
            clearTimeout(this.timeoutHandler)
        }

        this.timeoutHandler = setTimeout(() => {
            this.inputString = ''
        }, 10)
    }

    close = () => {
        // Currently not using this function
        // Can be use later for SPA, or in some pages where only want to enable one-time scan
        document.removeEventListener('keypress', this.keypress)
    }

    keypress = (e) => {
        if (this.timeoutHandler) {
            clearTimeout(this.timeoutHandler)
            const keyCode = e.which
            if ((keyCode >= 48 && keyCode <= 57) || keyCode === 13) {
                // Only listen keycode 0-9 and Enter, since ISBN and Member ID is numeric
                this.inputString += String.fromCharCode(keyCode);
            }
        }

        this.timeoutHandler = setTimeout(() => {
            if (this.inputString.length <= 3) {
                this.inputString = ''
                return
            }

            const event = new CustomEvent("onbarcodescanned", { detail: this.inputString });
            document.dispatchEvent(event);

            this.inputString = ''
        }, 10)
    }
}

window.BarcodeScanner = BarcodeScanner;