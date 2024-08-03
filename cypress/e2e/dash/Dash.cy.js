describe('Main Page', () => {
    before(() => {
        cy.visit('http://localhost:8085/login');
        cy.intercept('POST', '/api/login').as('loginRequest');
    
        cy.get('#email').type('teste5@usuario.com');
        cy.get('#password').type('senha123');
        cy.get('button').contains('Entrar').click();
    
        cy.wait('@loginRequest').then((interception) => {
            expect(interception.response.statusCode).to.eq(200);
            cy.url().should('include', '/dashboard');
        });
    });

    beforeEach(() => {
        cy.visit('http://localhost:8085/dashboard');
    });

       it('deve criar um funil com sucesso', () => {
        const funnel = { 
            name: 'Novo Funil',
            color: '#FF5733'
        };

        cy.intercept('POST', '/api/funnels').as('createFunnelRequest');

        // Clique para abrir o modal e verifique se ele está visível
        cy.get('[data-test="open-create-funnel-modal"]').click();
        cy.get('[data-test="create-funnel-modal"]').should('be.visible');
        
        cy.get('[data-test="funnel-name"]').type(funnel.name);
        cy.get('[data-test="funnel-color"]').type(funnel.color);
        cy.get('[data-test="create-funnel"]').click();

        cy.wait('@createFunnelRequest', { timeout: 10000 }).then((interception) => {
            expect(interception.response.statusCode).to.eq(201);
            cy.contains('Funil criado com sucesso!', { timeout: 10000 }).should('be.visible');
        });
    });


    it('deve deletar um funil com sucesso', () => {
        const funnelId = 1; 

        cy.intercept('POST', '/api/funnels').as('createFunnelRequest');
        const funnel = { 
            name: 'Funil para Deletar',
            color: '#FF5733'
        };
        cy.get('[data-test="open-create-funnel-modal"]').click();
        cy.get('[data-test="funnel-name"]').type(funnel.name);
        cy.get('[data-test="funnel-color"]').type(funnel.color);
        cy.get('[data-test="save-funnel"]').click();
        cy.wait('@createFunnelRequest');

        cy.intercept('DELETE', `/api/funnels/${funnelId}`).as('deleteFunnelRequest');

        cy.get(`[data-test="delete-funnel-${funnelId}"]`).click();
        cy.get('[data-test="confirm-delete"]').click();

        cy.wait('@deleteFunnelRequest').then((interception) => {
            expect(interception.response.statusCode).to.eq(200);
            cy.contains('Funil deletado com sucesso.').should('be.visible');
        });
    });
});
