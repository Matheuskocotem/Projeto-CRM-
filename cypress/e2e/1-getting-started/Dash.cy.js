describe('Dashboard Page', () => {
    beforeEach(() => {
      // Visita a página de login
      cy.visit('http://localhost:8085/dashboard');
      
      // Faz login com credenciais válidas
      cy.get('#email').type('carlos@gmail.com');
      cy.get('#password').type('12345678');
      cy.get('button[type="button"]', { timeout: 10000 }).click();
      
      // Aguarda o redirecionamento para a dashboard
      cy.url({ timeout: 10000 }).should('eq', 'http://localhost:8085/dashboard');
    });
  
    it('deve exibir a dashboard com sucesso', () => {
      // Verifica se o título da página está correto
      cy.get('h1').should('contain.text', 'Bem-vindo à Dashboard'); // Ajuste se necessário
      
      // Verifica se o conteúdo principal da página está visível
      cy.get('#main-content').should('be.visible');
      
      // Verifica se os funis estão sendo exibidos (ajuste conforme necessário)
      cy.get('CardFunnel').should('exist');
      
      // Verifica se a paginação está presente
      cy.get('Pagination').should('exist');
    });
  
    it('deve permitir criar um funil', () => {
   
      cy.get('[data-cy="create-funnel", { timeout: 10000 }]').click(); 
  
      // Preenche o formulário para criar um novo funil
      cy.get('#funnelName').type('Novo Funil');
      cy.get('#funnelColor').type('#ff0000'); // Ajuste o seletor se necessário
      
      // Submete o formulário
      cy.get('[data-cy="submit-funnel"]').click(); // Ajuste o seletor se necessário
  
      // Verifica se o funil foi criado com sucesso
      cy.contains('Funil criado com sucesso!').should('exist');
      
      // Verifica se o novo funil aparece na lista
      cy.get('CardFunnel').should('contain.text', 'Novo Funil');
    });
  });
  