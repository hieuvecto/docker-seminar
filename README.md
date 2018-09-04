# Hướng dẫn sử dụng

1. Tạo các máy ảo vagrant
```bash
vagrant up
```

2. Tạo và cài đặt container mysql trong database vagrant box
- ssh vào database box
```bash
vagrant ssh database //ssh vào database box

cd database

docker-compose up -d

exit //thoát khỏi box
```

3. Tạo và cài đặt container nginx và php
```bash
vagrant ssh app //ssh vào app box

cd app

docker-compose up -d

exit //thoát khỏi box
```

4. Kiểm tra kết nối nginx, php-fpm và mysql thành công hay chưa
- Truy cập http://192.168.33.25/index.php để kiểm tra, nếu thành công sẽ có dòng "Connected successfully" xuất hiện.

5. Cách lấy file log từ php-fpm

```bash
vagrant ssh app //ssh vào app box, nếu hiện đang ở trong box thì bỏ qua bước này

docker exec -it php-fpm bash

// cài đặt vim để dễ edit các file config
apt-get update
apt-get install -y vim

// Tiếp tục thực hiện từ bước 4 trở đi như phía dưới, với thư mục log đã chuẩn bị là /log/ trong container php-fpm
```
# Cách lấy file log từ php-fpm docker container

1. Mount folder log từ host đến docker container bằng docker-compose.
- Lưu ý folder log phải được đặt dưới quyền root
Ví dụ: 
```yaml
    volumes:
      - ./log:/log    # Chú ý có thể đổi đường dẫn folder trong container tùy thích

```
2. Exec vào php-fpm container
3. Kiểm tra /log có bị lỗi quyền phân quyền không bằng lệnh
```bash
$   stat /log
```
4. Nếu không có lỗi gì, thực hiện theo như blog sau 
- Link: http://www.tothenew.com/blog/php5-fpm-logging/
- Lưu ý đổi các đường dẫn như error.log, access.log slow.log vào đường dẫn folder log đã mount. 

4. Restart lại service php-fpm hoặc restart lại php-fpm container
- Khi đó, tại folder log ở host và folder log ở container đều sẽ tạo mới 2 file access.log và slow.log