describe('Página de Login', () => {
    beforeEach(() => {
      cy.visit('http://localhost:8085/login');
    });
  
    it('deve permitir que o usuário faça login com sucesso', () => {
      // Preencher o formulário de login
      cy.get('#email').type('joao.silva@example.com');
      cy.get('#password').type('123456');
  
      // Interceptar a requisição de login
      cy.intercept('POST', '/api/login', {
        statusCode: 200,
        body: { token: 'dummy_token', message: 'Login realizado com sucesso!' }
      }).as('loginRequest');
  
    });
  });
  