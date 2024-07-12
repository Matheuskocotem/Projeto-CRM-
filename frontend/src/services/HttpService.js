import CryptoJS from 'crypto-js';
import router from '../router';
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
    const token = response.data;
    console.log(token);
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
    router.push({ name: 'login' });
    return response.data;
    
  } catch (error) {
    console.error("Erro ao registrar:", error.response ? error.response.data : error.message);
    this.errorMessage = error.response ? error.response.data : 'Erro desconhecido';
    throw error;
  }
}

export default HttpService;
