describe('Testes de Funis e Etapas', () => {
    let token;
  
    before(() => {
      cy.request({
        method: 'POST',
        url: '/login',
        body: {
          email: 'teste@exemplo.com',
          password: 'senha123'
        }
      }).then((response) => {
        token = response.body.token;
      });
    });
  
    it('Deve criar um funil e listar os funis', () => {
      cy.request({
        method: 'POST',
        url: '/funnels',
        headers: {
          Authorization: `Bearer ${token}`
        },
        body: {
          name: 'Funil Teste'
        }
      }).then((response) => {
        expect(response.status).to.eq(201);
        expect(response.body).to.have.property('id');
        const funnelId = response.body.id;
  
        cy.request({
          method: 'GET',
          url: '/funnels',
          headers: {
            Authorization: `Bearer ${token}`
          }
        }).then((response) => {
          expect(response.status).to.eq(200);
          expect(response.body).to.be.an('array');
          expect(response.body).to.deep.include({ id: funnelId, name: 'Funil Teste' });
        });
      });
    });
  
    it('Deve criar e listar etapas', () => {
      cy.request({
        method: 'POST',
        url: '/funnels/1/stages',
        headers: {
          Authorization: `Bearer ${token}`
        },
        body: {
          name: 'Etapa 1',
          order: 1
        }
      }).then((response) => {
        expect(response.status).to.eq(201);
        expect(response.body).to.have.property('id');
        const stageId = response.body.id;
  
        cy.request({
          method: 'GET',
          url: '/funnels/1/stages',
          headers: {
            Authorization: `Bearer ${token}`
          }
        }).then((response) => {
          expect(response.status).to.eq(200);
          expect(response.body).to.be.an('array');
          expect(response.body).to.deep.include({ id: stageId, name: 'Etapa 1', order: 1 });
        });
      });
    });
  });
  