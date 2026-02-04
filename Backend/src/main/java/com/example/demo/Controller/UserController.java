package com.example.demo.Controller;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RestController;

import com.example.demo.Entity.User;
import com.example.demo.Service.MainService;



@CrossOrigin(origins = "*", allowedHeaders = "*", methods = {RequestMethod.GET, RequestMethod.POST, RequestMethod.PUT, RequestMethod.DELETE})
@RestController
@RequestMapping("/api/users")

public class UserController {
    @Autowired private MainService mainService;

    @PostMapping("/register")
    public User registerUser(@RequestBody User user) {
        return mainService.saveUser(user);
    }

    @GetMapping("/all")
    public List<User> getAll() {
        return mainService.getAllActiveUsers();
    }

    @PutMapping("/delete/{id}")
    public String delete(@PathVariable int id) {
        mainService.deleteUser(id);
        return "User Soft Deleted!";
    }
    @PutMapping("/update/{id}")
    public User updateUser(@PathVariable int id, @RequestBody User userDetails) {
        // MainService හරහා update එක සිදුකරමු
        return mainService.updateUser(id, userDetails);
    }

    // Edit කරද්දී පරණ data ටික Form එකට ගන්න මේකත් ඕනේ
    @GetMapping("/{id}")
    public User getUserById(@PathVariable int id) {
        return mainService.getUserById(id);
    }
}