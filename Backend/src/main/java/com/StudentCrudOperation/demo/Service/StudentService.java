package com.StudentCrudOperation.demo.Service;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.StudentCrudOperation.demo.Entity.Student;
import com.StudentCrudOperation.demo.Repository.StudentRepository;

@Service
public class StudentService {

	@Autowired
	StudentRepository studentRepo;

	public List<Student> getAllStudent() {
		return studentRepo.findAll();
	}

	public Student getStudentById(int id) {
		return studentRepo.findById(id).get();
	}

	public void addStudent(Student student) {
		studentRepo.save(student);
	}

	public void addListStudent(List<Student> studentList) {
		studentRepo.saveAll(studentList);
	}

	public Student updateStudent(int id, Student updateStudent) {
		Student student = studentRepo.findById(id).get();
		student.setName(updateStudent.getName());
		student.setPrecentage(updateStudent.getPrecentage());
		studentRepo.save(student);
		return student;
	}

	public void deleteStudent(int id) {
		studentRepo.delete(studentRepo.findById(id).get());
	}

}
