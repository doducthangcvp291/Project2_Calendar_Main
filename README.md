Project 2 Calendar App 
Do Duc Thang 20183830 IT2-K63 20212

Để khởi chạy project cần cài trước trong máy :

 + Composer ( cho việc chạy PHP Laravel )
 + Nodejs ( cho Vuejs )


Sau đó mở project , copy file .env.example thanh file .env , set up môi trường cấu hình trong file .env
Sau đó , chạy các lệnh sau để cài đặt các dependancy :
 + composer update 
 + npm install 
 + php artisan migrate 
 + php artisan jwt:secret

Khoi chạy dự án , mở 2 terminal , chạy đồng thời :
 + php artisan serve 
 + npm run watch