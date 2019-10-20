describe('Financing > Receivables page', () => {
    beforeEach(() => {
        cy.seed('user');
        cy.login();
    });

    it('Loads the receivables page', () => {
        cy.visit('/');

        cy.get('[data-cy=financing-module]').click();
        cy.get('[data-cy=receivable]')
            .should('be.visible')
            .and('contain', 'Contas a Receber')
            .click();

        cy.location()
            .its('pathname')
            .should('eq', '/contas-a-receber');

        cy.get('[data-cy=title]').should('contain', 'Contas a Receber');
        cy.title().should('be.eq', 'Contas a Receber');
    });
});
