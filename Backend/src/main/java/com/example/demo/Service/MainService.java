package com.example.demo.Service;

import java.util.List;
import java.util.Optional;
import java.util.stream.Collectors;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.example.demo.Entity.Admin;
import com.example.demo.Entity.ServiceRecord;
import com.example.demo.Entity.User;
import com.example.demo.Entity.Vehicle;
import com.example.demo.Repository.AdminRepository;
import com.example.demo.Repository.ServiceRecordRepository;
import com.example.demo.Repository.UserRepository;
import com.example.demo.Repository.VehicleRepository;

@Service
public class MainService {
    @Autowired private UserRepository userRepo;
    @Autowired private AdminRepository adminRepo;
    @Autowired private VehicleRepository vehicleRepo;
    @Autowired private ServiceRecordRepository serviceRepo;

    // --- LOGIN LOGIC ---
    public Object login(String username, String password) {
        // 1. Admin කෙනෙක්ද බලනවා (මතක ඇතුව AdminRepository එකෙත් මේ නමම දාන්න)
        Optional<Admin> admin = adminRepo.findByUsernameAndDeletestatus(username, 0); 
        if (admin.isPresent() && admin.get().getPassword().equals(password)) {
            return admin.get();
        }

        // 2. User කෙනෙක්ද බලනවා
        Optional<User> user = userRepo.findByEmailAndDeletestatus(username, 0);
        if (user.isPresent() && user.get().getPassword().equals(password)) {
            return user.get();
        }
        return null;
    }

    // --- USER CRUD ---
    @Autowired 
    private UserRepository userRepository; // මෙතන UserRepository කියන එක නිල් පාට වෙලා තියෙන්න ඕනේ

    // පරණ users ලා ගන්න එක
    public List<User> getAllActiveUsers() {
        return userRepository.findAll().stream()
                .filter(user -> user.getDeletestatus() == 0)
                .collect(Collectors.toList());
    }

    // Save කරන එක
    public User saveUser(User user) {
        return userRepository.save(user);
    }

    // Update කරන එක
    public User updateUser(int id, User userDetails) {
        User user = userRepository.findById(id)
            .orElseThrow(() -> new RuntimeException("User not found"));
            
        user.setFirstName(userDetails.getFirstName());
        user.setLastName(userDetails.getLastName());
        user.setEmail(userDetails.getEmail());
        user.setMobileNumber(userDetails.getMobileNumber());
        
        return userRepository.save(user);
    }

    // Soft Delete එක
    public void deleteUser(int id) {
        User user = userRepository.findById(id)
            .orElseThrow(() -> new RuntimeException("User not found"));
        user.setDeletestatus(1);
        userRepository.save(user);
    }

    // තනි User කෙනෙක්ව ගන්න එක (Edit වලට ඕනේ වෙනවා)
    public User getUserById(int id) {
        return userRepository.findById(id).orElse(null);
    }

    
    // --- VEHICLE CRUD ---
    public Vehicle saveVehicle(Vehicle vehicle) { 
        return vehicleRepo.save(vehicle); 
    }

    public Vehicle getVehicleByNumber(String vehicleNumber) {
        return vehicleRepo.findByVehicleNumberAndDeletestatus(vehicleNumber, 0).orElse(null);
    }

    public List<Vehicle> getAllActiveVehicles() {
        return vehicleRepo.findByDeletestatus(0);
    }

    public void deleteVehicle(int id) {
        vehicleRepo.softDeleteVehicle(id);
    }

    // --- SERVICE RECORD CRUD ---
    public ServiceRecord saveService(ServiceRecord service) {
        return serviceRepo.save(service);
    }

    public List<ServiceRecord> getAllActiveServices() {
        return serviceRepo.findByDeletestatus(0);
    }

    public void deleteService(int id) {
        serviceRepo.softDeleteService(id);
    }
}