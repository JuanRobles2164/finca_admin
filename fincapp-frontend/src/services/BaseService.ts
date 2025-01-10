/* eslint-disable */

import { CONSTANTS } from '@/common/Constants';
import { useNotificationStore } from '@/store/components/NotificationStore';
import axios, { AxiosInstance } from 'axios';

export default class BaseService {
  protected api: AxiosInstance;
  protected baseApiGroup : string;

  protected useNotificationStore = useNotificationStore();

  constructor(baseURL: string, baseApiGroup : string) {
    this.baseApiGroup = baseApiGroup;
    this.api = axios.create({
      baseURL,
      headers: {
        'Content-Type': 'application/json',
      },
    });

    this.api.interceptors.request.use((config : any) => {
      const token = localStorage.getItem('token');
      if (token) {
        config.headers['Authorization'] = `Bearer ${token}`;
      }
      return config;
    });
  }

  private prepareUrl(url: string){
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

  protected successOperationNotification(message : string = CONSTANTS.NOTIFICACIONES_MENSAJES_SUCCESS){
    this.useNotificationStore.addNotification("success", "Operación exitosa", message);
  }

  protected dangerOperationNotification(message : string = CONSTANTS.NOTIFICACIONES_MENSAJES_FAIL){
    this.useNotificationStore.addNotification("danger", "Operación fallida", message);
  }

  protected warningOperationNotification(message : string = CONSTANTS.NOTIFICACIONES_MENSAJES_WARNING){
    this.useNotificationStore.addNotification("warning", "Operación exitosa", message);
  }

  //Base methods for almost each repository

  public async baseGet<T>(url: string, params : any) : Promise<T>{
    return await this.get<T>(url, params);
  }

  public async find<T>(url: string, params : any) : Promise<T> {
    return await this.get<T>(url, params);
  }

  public async findByParams<T>(url : string, params: any) : Promise<T>{
    return await this.get<T>(url, params);
  }

  public async create<T>(url : string, params: any) : Promise<T>{
    return await this.get<T>(url, params);
  }

  public async update<T>(url : string, params : any) : Promise<T> {
    return await this.put(url, params);
  }

}