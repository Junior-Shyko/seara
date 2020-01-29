describe('Report > Debt and Payment', () => {
    beforeEach(() => {
        cy.cleanDatabase();
        cy.seed('user');
        cy.login();
    });

    it('Loads the report page', () => {
        cy.visit('/');

        cy.get('[data-cy=report-module').click();
        cy.get('[data-cy=report-debt-and-payment]')
            .should('be.visible')
            .and('contain', 'Dívidas e Pagamentos')
            .click();

        cy.location()
            .its('pathname')
            .should('eq', '/relatorio/dividas-e-pagamentos');

        cy.get('[data-cy=title]').should('contain', 'Relatório dívidas e pagamentos');
        cy.title().should('be.eq', 'Relatório - Dívidas e Pagamentos');
    });
});
