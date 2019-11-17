describe('Financing > Income category page', () => {
    function createIncomeCategory(data) {
        cy.window().then((win) => {
            let $ = win.$;
            let incomeCategoryResource = new win.ResourceModel('income-category');
            incomeCategoryResource.create(data);
        });

        cy.wait('@createIncomeCategory').then(() => {
            cy.window().then(win => {
                win.$('#table-income-category').DataTable().ajax.reload();
            });
        });
    }

    beforeEach(() => {
        cy.cleanDatabase();
        cy.seed('user');
        cy.login();
        cy.server();
        cy.route({
            method: 'POST',
            url: '/income-category'
        }).as('createIncomeCategory');
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

        cy.get('[data-cy=table]')
            .find('tbody > tr:first')
            .should('contain', 'Contratos');
    });

    it('Updates an income category', () => {
        cy.visit('/categoria-receita');

        createIncomeCategory({
            name: 'Contratos'
        });

        cy.get('[data-cy=table]')
            .find('tbody > tr:first i.fa.fa-pencil')
            .click();

        cy.get('input[name=name]').type('{selectAll}Venda de certificados');
        cy.get('[data-cy=submit]').click();

        cy.get('[data-cy=table]')
            .find('tbody > tr:first > td:first')
            .should('have.text', 'Venda de certificados');
    });

    it('Archives an income category', () => {
        cy.visit('/categoria-receita');

        createIncomeCategory({
            name: 'Contratos'
        });

        cy.get('[data-cy=table]')
            .find('tbody > tr:first i.fa.fa-ban')
            .click();

        cy.get('button.swal2-confirm')
            .click();

        cy.get('[data-cy=table]')
            .find('tbody tr td:first')
            .should('not.contain', 'Contratos')
    });
});
