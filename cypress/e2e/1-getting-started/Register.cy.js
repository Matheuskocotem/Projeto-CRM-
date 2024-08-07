
describe('Página de Registro', () => {
    beforeEach(() => {
      cy.visit('http://localhost:8085/register'); 
    });
  
    it('deve exibir o formulário de registro com os elementos corretos', () => {
      cy.get('#icons img').should('have.length', 3);
      
      cy.get('#title').should('exist');
      cy.get('#title-line').contains('Mais');
      cy.get('#subject').contains('Uma ferramenta all-in-one para você vender, atender, cobrar e otimizar o seu tempo e o seu dinheiro.');
      cy.get('#name').should('exist');
      cy.get('#email').should('exist');
      cy.get('#password').should('exist');
      cy.get('#password_confirmation').should('exist');
      cy.get('#docNum').should('exist');
      cy.get('input[name="btnradio"][value="CPF"]').should('be.checked');
      cy.get('input[name="btnradio"][value="CNPJ"]').should('exist');
    });
  
    it('deve permitir que o usuário se registre com sucesso', () => {
      cy.get('#name').type('João da Silva');
      cy.get('#email').type('joao.silva@example.com');
      cy.get('#password').type('123456');
      cy.get('#password_confirmation').type('123456');
      cy.get('#docNum').type('123.456.789-00');
  
      cy.intercept('POST', '/api/register', {
        statusCode: 201,
        body: { message: 'Registro realizado com sucesso!' }
      }).as('registerRequest');
  
      cy.get('button[type="button"]').click();
  
      cy.wait('@registerRequest').its('response.statusCode').should('eq', 201);
      cy.contains('Faça o seu login a seguir!').should('exist');
    });
});