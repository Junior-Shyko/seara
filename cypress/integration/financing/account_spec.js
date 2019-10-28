describe('Financing > Account page', () => {
    beforeEach(() => {
        cy.seed('user');
        cy.login();
    });

    it('Creates and lists an account', () => {
        cy.visit('/conta');
        cy.get('#create-account-btn').click();
        cy.get('input#name').type('Minha Conta Bancária');
        cy.get('#form-save-btn').click();
        cy.get('table#account-table > tbody > tr:first')
            .should('contain', 'Minha Conta Bancária');
    });
});
