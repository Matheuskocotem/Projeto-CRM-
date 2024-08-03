describe('Testes de Autenticação', () => {
    it('Deve permitir registro de usuário', () => {
      cy.request({
        method: 'POST',
        url: '/register',
        body: {
          name: 'Usuário Teste',
          email: 'teste@usuario.com',
          password: 'senha123',
          password_confirmation: 'senha123'
        }
      }).then((response) => {
        expect(response.status).to.eq(201);
        expect(response.body).to.have.property('token');
      });
    });
  
    it('Deve permitir login de usuário', () => {
      cy.request({
        method: 'POST',
        url: '/login',
        body: {
          email: 'teste@usuario.com',
          password: 'senha123'
        }
      }).then((response) => {
        expect(response.status).to.eq(200);
        expect(response.body).to.have.property('token');
      });
    });
  });
  