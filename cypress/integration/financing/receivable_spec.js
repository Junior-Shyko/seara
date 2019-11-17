import {assertFirstRowContains} from "../../support/assertions";

describe('Financing > Receivables page', () => {
    beforeEach(() => {
        cy.cleanDatabase();
        cy.seed('user');
        cy.login();
        cy.server();
        cy.route({
            method: 'GET',
            url: '/receivable/dataTable*'
        }).as('dataTable');
        cy.route({
            method: 'PUT',
            url: '/receivable/payment/*'
        }).as('payReceivable');
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
        cy.seed('receivable_spec.accounts_and_categories');
        cy.visit('/contas-a-receber');

        cy.get('[data-cy=create-btn]').click();

        cy.get('input[name=amount]:visible')
            .type('57000');
        cy.get('input[name=due_date]')
            .type('20092019');
        cy.get('input[name=description]')
            .type('Serviços de contabilidade');

        cy.get('#select2-income_category_id-container').click();
        cy.get('.select2-search__field').type('Venda de contratos{enter}');

        cy.get('#select2-account_id-container').click();
        cy.get('.select2-search__field').type('Itaú{enter}');

        cy.get('[data-cy=submit]').click();

        assertFirstRowContains([
            '20/09/2019',
            null, // ignore
            'Serviços de contabilidade',
            'Venda de contratos',
            'Itaú',
            '570'
        ]);
    });

    it('Partially pays a receivable', () => {
        cy.seed('receivable_spec.partial_payment');
        cy.visit('/contas-a-receber');

        cy.get('[data-cy=table]')
            .find('tbody tr:first i.fa.fa-check')
            .click();

        cy.get('input[name=amount]:visible')
            .type('{selectAll}110,48')
            .get('[data-cy=pay-receivable]')
            .click();

        cy.wait('@payReceivable');
        cy.wait('@dataTable');
        cy.wait(500);

        cy.get('[data-cy=table]')
            .find('tbody tr:first td')
            .eq(6)
            .should('contain', '110,48');

        cy.get('[data-cy=table]')
            .find('tbody tr:first i.fa.fa-check')
            .click();

        cy.get('input[name=amount]:visible')
            .type('{selectAll}314,73')
            .get('[data-cy=pay-receivable]')
            .click();

        cy.get('[data-cy=table]')
            .find('tbody tr')
            .should('not.contain', 'Mensalidade')
    });
});
