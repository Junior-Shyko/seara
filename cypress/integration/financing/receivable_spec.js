describe('Financing > Receivables page', () => {
    beforeEach(() => {
        cy.seed('receivable_spec');
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

    it('Creates and lists a receivable', () => {
        cy.get('[data-cy=create-btn]').click();

        cy.get('input[name=amount]')
            .type('57000');
        cy.get('input[name=due_date]')
            .type('20092019');
        cy.get('input[name=description]')
            .type('Serviços de contabilidade');
        cy.get('select[name=income_category_id]')
            .select('Venda de contratos');
        cy.get('select[name=account_id]')
            .select('Itaú');

        cy.get('[data-cy=submit]').click();

        cy.get('[data-cy=table]')
            .find('tbody tr:first td:first')
            .should('contain', '20/09/2019') // due date
            .next()
            .next()
            .should('contain', 'Serviços de contabilidade') // description
            .next()
            .should('contain', 'Venda de contratos') // category
            .next()
            .should('contain', 'Itaú') // account
            .next()
            .should('contain', '570') // amount
    });
});
