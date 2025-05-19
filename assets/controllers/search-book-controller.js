import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {

    static targets = ['q'];

    connect() {
        console.log("holaaaa, ¿todo bien?")
    }

    search() {


        clearTimeout(this.timeout)                         // debounce básico :contentReference[oaicite:8]{index=8}
        this.timeout = setTimeout(() => {
            this.element.requestSubmit()                    // envío capturado por Turbo :contentReference[oaicite:9]{index=9}
            this.element.querySelector('input').focus()     // reestablecer foco si hace falta :contentReference[oaicite:10]{index=10}
        }, 300)
    }
}
