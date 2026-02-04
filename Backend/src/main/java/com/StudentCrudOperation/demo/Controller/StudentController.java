package com.StudentCrudOperation.demo.Controller;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import com.StudentCrudOperation.demo.Entity.Student;
import com.StudentCrudOperation.demo.Service.StudentService;

@RestController
@RequestMapping("/api/students")
public class StudentController {

	@Autowired
	StudentService studentService;

	@GetMapping("/getAllStudentList")
	public List<Student> getAllStudent() {
		return studentService.getAllStudent();
	}

	@GetMapping("/getStudentById/{id}")
	public Student getStudentById(@PathVariable int id) {
		return studentService.getStudentById(id);
	}

	@PostMapping("/addStudent")
	public void addStudent(@RequestBody Student student) {
		studentService.addStudent(student);
	}

	@PostMapping("/addListStudent")
	public void addListStudent(@RequestBody List<Student> studentList) {
		studentService.addListStudent(studentList);
	}

	@PutMapping("/updatestudent/{id}")
	public Student updateStudent(@PathVariable int id, @RequestBody Student student) {
		return studentService.updateStudent(id, student);
	}

	@DeleteMapping("deleteStudent/{id}")
	public void deleteStudent(@PathVariable int id) {
		studentService.deleteStudent(id);

	}

}
