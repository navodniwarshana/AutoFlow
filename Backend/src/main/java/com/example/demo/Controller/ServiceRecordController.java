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
import org.springframework.web.bind.annotation.RestController;

import com.example.demo.Entity.ServiceRecord;
import com.example.demo.Service.MainService;
@RestController
@RequestMapping("/api/services")
@CrossOrigin("*")
public class ServiceRecordController {
    @Autowired private MainService mainService;

    @PostMapping("/add")
    public ServiceRecord addService(@RequestBody ServiceRecord service) {
        return mainService.saveService(service);
    }

    @GetMapping("/all")
    public List<ServiceRecord> getAll() {
        return mainService.getAllActiveServices();
    }

    @PutMapping("/delete/{id}")
    public String delete(@PathVariable int id) {
        mainService.deleteService(id);
        return "Service Record Soft Deleted!";
    }
}