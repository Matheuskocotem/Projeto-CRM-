describe('Main Page', () => {
    beforeEach(() => {
        cy.visit('http://localhost:8085/dashboard'); 
    });

    it('deve exibir todos os componentes corretamente', () => {
        cy.get('#app-container').should('be.visible');
        cy.get('SideBar').should('exist');
        cy.get('NavBar').should('exist');
        cy.get('CardFunnel').should('exist');
        cy.get('Pagination').should('exist');
    });

    it('deve permitir alternar o Sidebar', () => {
        cy.get('button#toggle-sidebar').click(); 

        cy.get('#main-content').should('have.css', 'margin-left', '200px');

        cy.get('button#toggle-sidebar').click(); 

        cy.get('#main-content').should('have.css', 'margin-left', '75px');
    });

    it('deve criar um funil com sucesso', () => {
        const funnel = {
            name: 'Novo Funil',
            color: '#FF5733'
        };

        cy.intercept('POST', '/api/funnels').as('createFunnelRequest');

        cy.get('button#open-create-funnel-modal').click();
        cy.get('input#funnel-name').type(funnel.name);
        cy.get('input#funnel-color').type(funnel.color);
        cy.get('button#save-funnel').click();

        cy.wait('@createFunnelRequest').then((interception) => {
            expect(interception.response.statusCode).to.eq(201); // Verifica se a resposta tem status 201
            cy.contains('Funil criado com sucesso!').should('be.visible');
        });
    });

    it('deve deletar um funil com sucesso', () => {

        cy.intercept('DELETE', `/api/funnels/${funnelId}`).as('deleteFunnelRequest');

        cy.get(`button#delete-funnel-${funnelId}`).click();
        cy.get('button#confirm-delete').click();

        cy.wait('@deleteFunnelRequest').then((interception) => {
            expect(interception.response.statusCode).to.eq(200); 
            cy.contains('Funil deletado com sucesso.').should('be.visible');
        });
    });

    it('deve exibir a paginação corretamente', () => {
        cy.get('Pagination').should('be.visible');
        cy.get('button#next-page').click(); 

        cy.url().should('include', 'page=2');
    });
});
