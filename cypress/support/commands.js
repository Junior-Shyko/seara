const email = 'ford@megadodo.com';
const password = '4242';

Cypress.Commands.add('seed', seed => {
    cy.request('/seed/' + seed);
});

Cypress.Commands.add('login', () => {
    cy.request('/login')
        .its('body')
        .then(body => {
            const pattern = /<meta name="_token" content="(.+?)">/;
            let result = pattern.exec(body);
            cy.request('POST', '/login', {
                email,
                password,
                _token: result[1]
            });
        });
});
