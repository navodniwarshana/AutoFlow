package com.example.demo.Repository;

import java.util.List;
import java.util.Optional;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Modifying;
import org.springframework.data.jpa.repository.Query;
import org.springframework.stereotype.Repository;
import org.springframework.transaction.annotation.Transactional;

import com.example.demo.Entity.User;

@Repository
public interface UserRepository extends JpaRepository<User, Integer> {

    // 1. Email එකෙන් සහ status එකෙන් User කෙනෙක්ව හොයන්න (Login එකට)
    Optional<User> findByEmailAndDeletestatus(String email, int status);

    // 2. Active User ලා ඔක්කොම ගන්න
    List<User> findByDeletestatus(int status);

    // 3. Soft delete කරන්න query එක
    @Modifying
    @Transactional
    @Query("UPDATE User u SET u.deletestatus = 1 WHERE u.id = :id")
    void softDeleteUser(int id);
}