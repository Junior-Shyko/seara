describe('Login flow', () => {
    beforeEach(() => {
        cy.cleanDatabase();
        cy.seed('user');
    });

    it('Redirects the user to the login page when not logged in', () => {
        cy.visit('/');
        cy.url().should('contain', '/login')
    });

    it('logs in the user', () => {
        cy.visit('/login');

        cy.get('[name=email]').type('ford@megadodo.com');
        cy.get('[name=password]').type('4242{enter}');

        cy.get('body').should('contain', 'Ford Prefect');
    });
});
