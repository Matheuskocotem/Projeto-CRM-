describe('Register Page', () => {
    beforeEach(() => {
        cy.visit('http://localhost:8085/register'); 
    });

    it('deve exibir o formulário de inscrição', () => {
        cy.get('form').should('be.visible');
    });

    it('deve exigir todos os campos', () => {

            cy.get('button').click();
            cy.get('input#name').should('exist');
            cy.get('input#email').should('exist');
            cy.get('input#password').should('exist');
            cy.get('input#password_confirmation').should('exist');
            cy.get('input#docNum').should('exist');
    });

    it('deve registrar um novo user', () => {
        cy.get('#name').type('Teste Usuário');
        cy.get('#email').type('teste5@usuario.com');
        cy.get('#password').type('senha123');
        cy.get('#password_confirmation').type('senha123');
        cy.get('#btnradio1').check();
        cy.get('#docNum').type('123.456.889-20');
    
        cy.intercept('POST', '/api/register').as('registerRequest');

        cy.get('button').click();

        cy.wait('@registerRequest').then((interception) => {
           assert.equal(interception.response.statusCode, 201, 'Cadastro bem-sucedido');
           cy.contains('Faça o seu login a seguir!').should('be.visible');
    });

    cy.url().should('include', '/login');
  });
});