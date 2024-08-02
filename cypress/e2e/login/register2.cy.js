describe('Register Page', () => {
    beforeEach(() => {
        cy.visit('http://localhost:8085/register'); 
    });

    it('deve exibir o formulário de inscrição', () => {
        cy.get('form').should('be.visible');
    });

    it('deve exigir todos os campos', () => {
        cy.get('button').click(); // Clica no botão sem preencher os campos
        cy.get('input#name').should('exist');
        cy.get('input#email').should('exist');
        cy.get('input#password').should('exist');
        cy.get('input#password_confirmation').should('exist');
        cy.get('input#docNum').should('exist');
    });

    const users = Array.from({ length: 50 }, (_, index) => ({
        name: `Usuário Teste ${index + 1}`,
        email: `teste${index + 1}@usuario.com`,
        password: 'senha123',
        docNum: `123.456.89${index + 1}-20`
    }));

    users.forEach(({ name, email, password, docNum }) => {
        it(`deve registrar o usuário com email ${email}`, () => {
            cy.visit('http://localhost:8085/register'); 

            cy.get('#name').type(name);
            cy.get('#email').type(email);
            cy.get('#password').type(password);
            cy.get('#password_confirmation').type(password);
            cy.get('#btnradio1').check(); // Selecione o rádio de gênero ou qualquer outro elemento necessário
            cy.get('#docNum').type(docNum);

            cy.intercept('POST', '/api/register').as('registerRequest');

            cy.get('button').click();

            cy.wait('@registerRequest').then((interception) => {
                assert.equal(interception.response.statusCode, 201, 'Cadastro bem-sucedido');
                cy.contains('Faça o seu login a seguir!').should('be.visible');
                cy.url().should('include', '/login');
            });
        });
    });
});
