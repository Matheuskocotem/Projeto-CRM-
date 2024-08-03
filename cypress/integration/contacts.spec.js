describe('Testes de Contatos', () => {
    let token;
    let funnelId;
    let stageId;
  
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
  
      cy.request({
        method: 'POST',
        url: '/funnels',
        headers: {
          Authorization: `Bearer ${token}`
        },
        body: {
          name: 'Funil Teste para Contatos'
        }
      }).then((response) => {
        funnelId = response.body.id;
        
        cy.request({
          method: 'POST',
          url: `/funnels/${funnelId}/stages`,
          headers: {
            Authorization: `Bearer ${token}`
          },
          body: {
            name: 'Etapa Teste',
            order: 1
          }
        }).then((response) => {
          stageId = response.body.id;
        });
      });
    });
  
    it('Deve criar, listar, atualizar e excluir um contato', () => {
      cy.request({
        method: 'POST',
        url: `/funnels/${funnelId}/contacts`,
        headers: {
          Authorization: `Bearer ${token}`
        },
        body: {
          position: 1,
          name: 'Contato Teste',
          funnel_id: funnelId,
          stage_id: stageId,
          email: 'contato@exemplo.com',
          phoneNumber: '1234567890',
          buyValue: 100
        }
      }).then((response) => {
        expect(response.status).to.eq(201);
        expect(response.body).to.have.property('id');
        const contactId = response.body.id;
  
        cy.request({
          method: 'GET',
          url: `/funnels/${funnelId}/contacts`,
          headers: {
            Authorization: `Bearer ${token}`
          }
        }).then((response) => {
          expect(response.status).to.eq(200);
          expect(response.body).to.be.an('array');
          expect(response.body).to.deep.include({ id: contactId, name: 'Contato Teste' });
        });
  
        cy.request({
          method: 'PUT',
          url: `/funnels/${funnelId}/contacts/${contactId}`,
          headers: {
            Authorization: `Bearer ${token}`
          },
          body: {
            position: 2,
            name: 'Contato Teste Atualizado'
          }
        }).then((response) => {
          expect(response.status).to.eq(200);
          expect(response.body).to.have.property('name', 'Contato Teste Atualizado');
        });
  
        cy.request({
          method: 'DELETE',
          url: `/funnels/${funnelId}/contacts/${contactId}`,
          headers: {
            Authorization: `Bearer ${token}`
          }
        }).then((response) => {
          expect(response.status).to.eq(204);
        });
      });
    });
  });
  