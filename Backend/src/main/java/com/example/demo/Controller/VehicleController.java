package com.example.demo.Controller;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import com.example.demo.Entity.Vehicle;
import com.example.demo.Service.MainService;

@RestController
@RequestMapping("/api/vehicles")
@CrossOrigin("*")
public class VehicleController {
    @Autowired private MainService mainService;

    @PostMapping("/add")
    public Vehicle addVehicle(@RequestBody Vehicle vehicle) {
        return mainService.saveVehicle(vehicle);
    }

    @GetMapping("/all")
    public List<Vehicle> getAll() {
        return mainService.getAllActiveVehicles();
    }

    @GetMapping("/find/{vNumber}")
    public ResponseEntity<Vehicle> getByNumber(@PathVariable String vNumber) {
        Vehicle v = mainService.getVehicleByNumber(vNumber);
        return v != null ? ResponseEntity.ok(v) : ResponseEntity.notFound().build();
    }

    @PutMapping("/delete/{id}")
    public String delete(@PathVariable int id) {
        mainService.deleteVehicle(id);
        return "Vehicle Soft Deleted!";
    }
}