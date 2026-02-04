package com.StudentCrudOperation.demo.Repository;

import org.springframework.data.jpa.repository.JpaRepository;

import com.StudentCrudOperation.demo.Entity.Student;

public interface StudentRepository extends JpaRepository<Student, Integer> {

}
