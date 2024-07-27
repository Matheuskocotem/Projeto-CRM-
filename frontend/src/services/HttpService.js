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

export const resetPassword = (email) => {
  return axios.post(`/password.reset`, { email });
};  

export const createFunnel = async (funnel, token) => {
  return await HttpService.post('/funnels', funnel, {
    headers: {
      Authorization: `Bearer ${token}`
    }
  });
}

export const getFunnels = async (token) => {
  return await HttpService.get(`/funnels`, {
    headers: {
      Authorization: `Bearer ${token}`
    }
  });
}

export const destroyFunnel = async (funnel_id, token) => {
  return await HttpService.delete(`/funnels/${funnel_id}`, {
    headers: {
      Authorization: `Bearer ${token}`
    }
  });
}

export const createContact = async (contact, token, funnel_id) => {
  return await HttpService.post(`/contacts/${funnel_id}`, contact, {
    headers: {
      Authorization: `Bearer ${token}`
    }
  });
}

export const getContacts = async (token, funnel_id) => {
  return await HttpService.get(`/contacts/${funnel_id}`, {
    headers: {
      Authorization: `Bearer ${token}`
    }
  });
}

export const updateContact = async (contact, token, contact_id) => {
  return await HttpService.put(`/contacts/${contact_id}`, contact, {
    headers: {
      Authorization: `Bearer ${token}`
    }
  });
}

export const getStages = async (token, funnel_id) => {
  return await HttpService.get(`${funnel_id}/stages/`, {
    headers: {
      Authorization: `Bearer ${token}`
    }
  });
}

export default HttpService;