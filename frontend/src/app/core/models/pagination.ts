export interface Pagination<T>{
  data:T[];
  links:any;
  meta:{
    current_page:number;
    last_page:number;
    per_page:number;
    total:number;
  };
}
