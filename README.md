# Yêu cầu
1. VirtualBox
- Link cài đặt: https://www.virtualbox.org/wiki/Downloads
2. Vagrant
- Link cài đặt: https://www.vagrantup.com/downloads.html
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

5. Tùy biến cấu hình php-fpm (Không bắt buộc)

- thư mục app/php-fpm/config chứa 2 file config của php-fpm, ta có thể thay đổi ngay tại đây và restart lại php-fpm container.
- xem log php-fpm ở app/php-fpm/log
# Cách lấy file log từ php-fpm docker container

1. Mount các file và folder cần thiết
- folder log từ host đến docker container bằng docker-compose.
- 2 file config của php-fpm
- Lưu ý folder và file được mount phải được đặt dưới quyền root
Ví dụ: 
```yaml
    volumes:
      - ./log:/log    # Chú ý có thể đổi đường dẫn folder trong container tùy thích
      - ./host/path/php-fpm.conf:/container/path/php-fpm.conf
      - ./host/path/www.conf:/container/path/www.conf

```
4. Thực hiện thay đổi các file config từ bên ngoài theo như blog sau 
- Link: http://www.tothenew.com/blog/php5-fpm-logging/
- Lưu ý đổi các đường dẫn như error.log, access.log slow.log vào đường dẫn folder log đã mount. 
4. Restart lại service php-fpm hoặc restart lại php-fpm container
- Khi đó, tại folder log ở host và folder log ở container đều sẽ tạo mới 2 file access.log và slow.log
- File error.log phải tạo sẵn vì nó không tự tạo như access.log và slow.log

