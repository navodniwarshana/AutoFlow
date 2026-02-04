package com.example.demo.Repository;

import java.util.List;
import java.util.Optional;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import com.example.demo.Entity.Admin;

@Repository
public interface AdminRepository extends JpaRepository<Admin, Integer> {
    
    // 1. මේක තමයි Login එකට ඕනේ වෙන්නේ
    Optional<Admin> findByUsernameAndDeletestatus(String username, int status);

    // 2. මේක Active Admin ලා ඔක්කොම ගන්න
    List<Admin> findByDeletestatus(int status);
    
}