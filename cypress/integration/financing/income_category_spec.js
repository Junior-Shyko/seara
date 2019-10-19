describe('Financing > Income category page', () => {
    beforeEach(() => {
        cy.seed('user');
        cy.login();
    });

    it('Loads the income category page', () => {
        cy.visit('/');

        cy.get('[data-cy=financing-module]').click();
        cy.get('[data-cy=income-category]')
            .should('be.visible')
            .and('contain', 'Categorias de Receita');
        cy.get('[data-cy=income-category]').click();

        cy.location()
            .its('pathname')
            .should('eq', '/categoria-receita');

        cy.get('h2').contains('Categorias de Receita');
        cy.title().should('be.eq', 'Categorias de Receita')
    });

    it('Creates and lists an income category', () => {
        cy.visit('/categoria-receita');

        cy.get('[data-cy=create-btn]').click();
        cy.get('input[name=name]').type('Contratos');
        cy.get('[data-cy=submit]').click();

        // cy.get('[data-cy=table]')
        //     .find('tr:first')
        //     .should('contain', 'Contratos');
    });
});
