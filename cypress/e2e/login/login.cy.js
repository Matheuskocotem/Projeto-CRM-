describe('Login Page', () => {
    beforeEach(() => {
        cy.visit('http://localhost:8085/login'); // Visita a página de login
    });

    it('deve exibir o formulário de login', () => {
        cy.get('#email').should('exist'); // Verifica se o campo de email existe
        cy.get('#password').should('exist'); // Verifica se o campo de senha existe
        cy.get('button').contains('Entrar').should('exist'); // Verifica se o botão "Entrar" existe
    });

    it('deve exigir todos os campos', () => {
        cy.get('button').contains('Entrar').click(); // Clica no botão sem preencher os campos

        cy.get('#email').should('have.value', ''); // Verifica se o campo de email está vazio
        cy.get('#password').should('have.value', ''); // Verifica se o campo de senha está vazio
    });

    it('deve permitir o login com credenciais válidas', () => {
        cy.intercept('POST', '/api/login').as('loginRequest'); // Intercepta a requisição de login

        cy.get('#email').type('teste5@usuario.com'); // Preenche o campo de email
        cy.get('#password').type('senha123'); // Preenche o campo de senha
        cy.get('button').contains('Entrar').click(); // Clica no botão "Entrar"

        cy.wait('@loginRequest').then((interception) => {
            expect(interception.response.statusCode).to.eq(200); // Verifica se a resposta tem status 200
        });
        
        cy.url().should('include', '/dashboard'); // Verifica se o redirecionamento para o dashboard ocorreu
    });

    it('deve não permitir o login com credenciais inválidas', () => {
        cy.intercept('POST', '/api/login').as('loginRequest');
    
        const email = 'emailinvalido@usuario.com'; // E-mail inválido
        const senha = 'senhaerrada'; // Senha inválida
    
        cy.get('#email').type(email); // Preenche o campo de email com o valor inválido
        cy.get('#password').type(senha); // Preenche o campo de senha com a senha inválida
        cy.get('button').contains('Entrar').click(); // Clica no botão "Entrar"
    
        cy.wait('@loginRequest').then((interception) => {
          expect(interception.response.statusCode).to.eq(401); // Verifica se a resposta tem status 401
        });
    
        // Verifica se a URL não inclui '/dashboard'
        cy.url().should('not.include', '/dashboard'); // Garante que não ocorreu redirecionamento para o dashboard
      });
});
