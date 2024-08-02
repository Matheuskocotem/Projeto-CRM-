describe('Main Page', () => {
    beforeEach(() => {
        cy.visit('http://localhost:8085'); // Visita a página principal
    });

    it('deve exibir todos os componentes corretamente', () => {
        // Verifica se todos os componentes principais estão visíveis
        cy.get('#app-container').should('be.visible');
        cy.get('SideBar').should('exist');
        cy.get('NavBar').should('exist');
        cy.get('CardFunnel').should('exist');
        cy.get('Pagination').should('exist');
    });

    it('deve permitir alternar o Sidebar', () => {
        // Testa o comportamento de alternância do Sidebar
        cy.get('button#toggle-sidebar').click(); // Supondo que haja um botão para alternar o sidebar

        // Verifica se o estilo foi aplicado corretamente para o sidebar expandido
        cy.get('#main-content').should('have.css', 'margin-left', '200px');

        cy.get('button#toggle-sidebar').click(); // Alterna o sidebar de volta

        // Verifica se o estilo foi aplicado corretamente para o sidebar recolhido
        cy.get('#main-content').should('have.css', 'margin-left', '75px');
    });

    it('deve criar um funil com sucesso', () => {
        const funnel = {
            name: 'Novo Funil',
            color: '#FF5733'
        };

        cy.intercept('POST', '/api/funnels').as('createFunnelRequest');

        // Interage com o modal de criação de funil
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
        const funnelId = 1; // ID do funil para deletar

        cy.intercept('DELETE', `/api/funnels/${funnelId}`).as('deleteFunnelRequest');

        // Interage com o botão de deleção de funil
        cy.get(`button#delete-funnel-${funnelId}`).click();
        cy.get('button#confirm-delete').click(); // Confirma a deleção

        cy.wait('@deleteFunnelRequest').then((interception) => {
            expect(interception.response.statusCode).to.eq(200); // Verifica se a resposta tem status 200
            cy.contains('Funil deletado com sucesso.').should('be.visible');
        });
    });

    it('deve exibir a paginação corretamente', () => {
        // Verifica se a paginação está visível e funciona
        cy.get('Pagination').should('be.visible');
        cy.get('button#next-page').click(); // Supondo que haja um botão para avançar para a próxima página

        // Verifica se a página foi avançada
        cy.url().should('include', 'page=2'); // Ajuste conforme sua lógica de paginação
    });
});
