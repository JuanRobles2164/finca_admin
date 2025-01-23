/* eslint-disable */

import { CONSTANTS } from '@/common/Constants';
import { useNotificationStore } from '@/store/components/NotificationStore';
import axios, { AxiosInstance } from 'axios';

export default class BaseService {
  protected api: AxiosInstance;
  protected baseApiGroup: string;

  protected getUseNotificationStore() {
    return useNotificationStore();
  }

  constructor(baseURL: string, baseApiGroup: string) {
    this.baseApiGroup = baseApiGroup;
    this.api = axios.create({
      baseURL,
      headers: {
        'Content-Type': 'application/json',
      },
    });

    this.api.interceptors.request.use((config: any) => {
      const token = localStorage.getItem('token');
      if (token) {
        config.headers['Authorization'] = `Bearer ${token}`;
      }
      return config;
    });
  }

  protected async postFormData<T>(url: string, data: any): Promise<T> {
    let formData = new FormData();

    if (data instanceof FormData) {
        // Si `data` ya es FormData, lo usamos directamente
        formData = data;
    } else {
        // Convertimos `data` a FormData manualmente
        Object.keys(data).forEach(key => {
            const value = data[key];

            if (Array.isArray(value)) {
                formData.append(key, JSON.stringify(value));
            } else if (value instanceof File) {
                formData.append(key, value);
            } else {
                formData.append(key, JSON.stringify(value));
            }
        });
    }
    const response = await this.api.post<T>(this.prepareUrl(url), formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
    });

    return response.data;
}

  private prepareUrl(url: string) {
    return (this.baseApiGroup + url).toString();
  }

  // Http methods and verbs
  protected async get<T>(url: string, params?: any): Promise<T> {
    const response = await this.api.get<T>(this.prepareUrl(url), { params });
    return response.data;
  }

  protected async post<T>(url: string, data: any): Promise<T> {
    const response = await this.api.post<T>(this.prepareUrl(url), data);
    return response.data;
  }

  protected async put<T>(url: string, data: any): Promise<T> {
    const response = await this.api.put<T>(this.prepareUrl(url), data);
    return response.data;
  }

  protected successOperationNotification(message: string = CONSTANTS.NOTIFICACIONES_MENSAJES.SUCCESS) {
    this.getUseNotificationStore().addNotification("success", "Operación exitosa", message);
  }

  protected dangerOperationNotification(message: string = CONSTANTS.NOTIFICACIONES_MENSAJES.FAIL) {
    this.getUseNotificationStore().addNotification("danger", "Operación fallida", message);
  }

  protected warningOperationNotification(message: string = CONSTANTS.NOTIFICACIONES_MENSAJES.WARNING) {
    this.getUseNotificationStore().addNotification("warning", "Operación exitosa", message);
  }

  //Base methods for almost each repository

  public async baseGet<T>(url: string, params: any): Promise<T> {
    return await this.get<T>(url, params);
  }

  public async find<T>(url: string, params: any): Promise<T> {
    return await this.get<T>(url, params);
  }

  public async findByParams<T>(url: string, params: any): Promise<T> {
    return await this.get<T>(url, params);
  }

  public async create<T>(url: string, params: any): Promise<T> {
    return await this.postFormData<T>(url, params);
  }

  public async update<T>(url: string, params: any): Promise<T> {
    return await this.put(url, params);
  }

}