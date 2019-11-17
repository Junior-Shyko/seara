/**
 * @param {array} columns
 */
function assertFirstRowContains(columns) {
    if (columns.length === 0) {
        return;
    }

    let cell = cy.get('[data-cy=table]')
        .find('tbody tr:first td:first');

    let firstElement = columns.shift();
    if (null !== firstElement) {
        cell = cell.should('contain', firstElement).next();
    }

    columns.forEach(function (element) {
        if (null !== element) {
            cell = cell.should('contain', element);
        }
        cell = cell.next();
    });
}

export {
    assertFirstRowContains,
};
