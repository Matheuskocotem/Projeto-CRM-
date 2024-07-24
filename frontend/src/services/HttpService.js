import axios from "axios";


const HttpService = axios.create({
  baseURL: "http://localhost:8000/api",
  headers: {
    "Content-type": "application/json",
    Accept: "application/json"
  },
});

export const login = async (email, password) => {
  return await HttpService.post('/login', {
    email: email,
    password: password
  });
};

export const register = async (name, email, password, password_confirmation, documentType, documentNumber) => {
  return await HttpService.post('/register', {
    name: name,
    email: email,
    password: password,
    password_confirmation: password_confirmation,
    documentType: documentType,
    documentNumber: documentNumber
  });
}

export const createFunnel = async (funnel, token) => {
  return await HttpService.post('/funnel', funnel, {
    headers: {
      Authorization: `Bearer ${token}`
    }
  });
}

export const getFunnels = async (token, user_id) => {
  return await HttpService.get(`/funnels`, {
    headers: {
      Authorization: `Bearer ${token}`
    }
  });
}

export const destroyFunnel = async (funnelId, token) => {
  return await HttpService.delete(`/funnel/${funnelId}`, {
    headers: {
      Authorization: `Bearer ${token}`
    }
  });
}

export default HttpService;
