import axios from "axios";

const HttpService = axios.create({
  baseURL: "http://localhost:8000/api",
  headers: {
    "Content-type": "application/json",
    Accept: "application/json",
  },
});

// parte de login, registro, resetpassword e autenticação

export const login = async (email, password) => {
  return await HttpService.post("/login", {
    email: email,
    password: password,
  });
};

export const register = async (
  name,
  email,
  password,
  password_confirmation,
  documentType,
  documentNumber
) => {
  return await HttpService.post("/register", {
    name: name,
    email: email,
    password: password,
    password_confirmation: password_confirmation,
    documentType: documentType,
    documentNumber: documentNumber,
  });
};

export const resetPassword = (email) => {
  return axios.post(`/password.reset`, { email });
};

// parte de criação de funil

export const createFunnel = async (funnel, token) => {
  return await HttpService.post("/funnels", funnel, {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  });
};

export const getFunnels = async (token) => {
  return await HttpService.get(`/funnels`, {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  });
};

export const destroyFunnel = async (funnel_id, token) => {
  return await HttpService.delete(`/funnels/${funnel_id}`, {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  });
};
// parte de criação de etapa

export const getStages = async (funnel_id, token) => {
  return await HttpService.get(`funnels/${funnel_id}/stages/`, {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  });
};

export const createStage = async (funnel_id, stage, token) => {
  return await HttpService.post(`funnels/${funnel_id}/stages/`, stage, {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  });
};

export const updateStage = async (funnel_id, stage, stage_id, token) => {
  return await HttpService.put(
    `funnels/${funnel_id}/stages/${stage_id}`,
    stage,
    {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
  );
};

export const destroyStage = async (funnel_id, stage_id, token) => {
  return await HttpService.delete(`funnels/${funnel_id}/stages/${stage_id}`, {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  });
};

// parte de criação de etapa

export const getStages = async (funnel_id ,token) => {
  return await HttpService.get(`funnels/${funnel_id}/stages/`, {
    headers: {
      Authorization: `Bearer ${token}`
    }
  })
}

export const createStage = async (funnel_id, stage, token) => {
  return await HttpService.post(`funnels/${funnel_id}/stages/`, stage, {
    headers: {
      Authorization: `Bearer ${token}`
    }
  })
}

export const updateStage = async (funnel_id, stage, token, stage_id) => {
  return await HttpService.put(`funnels/${funnel_id}/stages/${stage_id}`, stage, {
    headers: {
      Authorization: `Bearer ${token}`
    }
  })
}

export const destroyStage = async (funnel_id, stage_id, token) => {
  return await HttpService.delete(`funnels/${funnel_id}/stages/${stage_id}`, {
    headers: {
      Authorization: `Bearer ${token}`
    }
  })
}

// parte de criação de contato

export const getContacts = async (funnel_id, stage_id, token) => {
  return await HttpService.get(`${funnel_id}/contacts/${stage_id}`, {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  });
};

export const createContact = async (funnel_id, contact, token) => {
  return await HttpService.post(`${funnel_id}/contacts/`, contact, {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  });
};

export const updateContact = async (funnel_id, contact, contact_id, token) => {
  return await HttpService.put(`${funnel_id}/contacts/${contact_id}`, contact, {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  });
};

export const destroyContact = async (funnel_id, contact_id, token) => {
  return await HttpService.delete(`${funnel_id}/contacts/${contact_id}`, {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  });
};

export default HttpService;