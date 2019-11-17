/// <reference types="Cypress" />

declare namespace Cypress {
    interface Chainable {
        seed(seed: string): Cypress.Chainable<JQuery>;
        login(): Cypress.Chainable<JQuery>;
        cleanDatabase(): Cypress.Chainable<JQuery>;
    }
}
