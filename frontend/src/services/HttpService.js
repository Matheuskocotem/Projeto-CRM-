import CryptoJS from 'crypto-js';
import axios from "axios";

const HttpService = axios.create({
  baseURL: "http://localhost:8000/api",
  headers: {
    "Content-type": "application/json", 
  },
});

export const encryptToken = (token) => {
  const secretKey = process.env.VUE_APP_SECRET_KEY;
  return CryptoJS.AES.encrypt(token, secretKey).toString();
};

export const decryptToken = (encryptedToken) => {
  const secretKey = process.env.VUE_APP_SECRET_KEY;
  const bytes = CryptoJS.AES.decrypt(encryptedToken, secretKey);
  return bytes.toString(CryptoJS.enc.Utf8);
};

export const login = async (email, password) => {
  try {
    const response = await HttpService.post('/login', {
      email: email,
      password: password
    });
    return response.data;
  } catch (error) {
    console.error('Erro ao fazer login:', error);
    throw error;
  }
};

export const register = async (name, email, password, password_confirmation, documentType, documentNumber) => {
  try {
    const response = await HttpService.post('/register', {
      name: name,
      email: email,
      password: password,
      password_confirmation: password_confirmation,
      documentType: documentType,
      documentNumber: documentNumber
    });
    return response.data;
    
  } catch (error) {
    console.error("Erro ao registrar:", error.response);
    throw error;
  }
}

export const funnel = async (name, user_id) => {
  try {
    const response = await HttpService.post('/funnel', {
      name: name,
      user_id: user_id
    });
    return response.data;
  } catch (error) {
    throw error;
  }
}

export default HttpService;
