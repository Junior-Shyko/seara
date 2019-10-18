Cypress.Commands.add('seed', seed => {
    cy.request('/seed/' + seed);
});
