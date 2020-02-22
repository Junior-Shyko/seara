describe('Financing > Payments page', () => {
    beforeEach(() => {
        cy.cleanDatabase();
        cy.seed('user');
        cy.login();
    });

    it('Loads the payment page', () => {
        cy.visit('/');

        cy.get('[data-cy=financing-module]').click();
        cy.get('[data-cy=payment]')
            .should('be.visible')
            .and('contain', 'Pagamentos')
            .click();

        cy.location()
            .its('pathname')
            .should('eq', '/pagamentos');

        cy.get('[data-cy=title]').should('contain', 'Pagamentos');
        cy.title().should('be.eq', 'Pagamentos');
    });
});
