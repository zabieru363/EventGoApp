"use strict";

export default class Event {
    
    // Atributos de clase
    #id;
    #title;
    #description;
    #admin;
    #city;
    #startDate;
    #endingDate;
    #images;
    #category;
    #active;
    #rule;

    constructor(id, title, description, admin, city, startDate, endingDate, images, category, active, rule = 1) {
        this.#id = id;
        this.#title = title;
        this.#description = description;
        this.#admin = admin;
        this.#city = city;
        this.#startDate = startDate;
        this.#endingDate = endingDate;
        this.#images = images;
        this.#category = category;
        this.#active = active;
        this.#rule = rule;

        Object.keys(this).forEach(function(key) {
            Object.defineProperty(this, key, {
                enumerable: true,
                writable: false,
                configurable: false
            });
        });

        Object.freeze(this);
    }

    // Getters y setters de propiedad

    get id() {
        return this.#id;
    }

    get title() {
        return this.#title;
    }

    get description() {
        return this.#description;
    }

    get admin() {
        return this.#admin;
    }

    get city() {
        return this.#city;
    }

    get startDate() {
        return this.#startDate;
    }

    get endingDate() {
        return this.#endingDate;
    }

    get images() {
        return this.#images.split("/");
    }

    get category() {
        return this.#category;
    }

    get active() {
        return this.#active;
    }

    get rule() {
        return this.#rule;
    }
}