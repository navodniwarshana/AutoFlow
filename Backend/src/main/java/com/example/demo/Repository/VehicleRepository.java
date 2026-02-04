package com.example.demo.Repository;

import java.util.List;
import java.util.Optional;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Modifying;
import org.springframework.data.jpa.repository.Query;
import org.springframework.stereotype.Repository;
import org.springframework.transaction.annotation.Transactional;
import com.example.demo.Entity.Vehicle;

@Repository
public interface VehicleRepository extends JpaRepository<Vehicle, Integer> {
    
    // MainService එකේ පාවිච්චි කරන findBy methods
    Optional<Vehicle> findByVehicleNumberAndDeletestatus(String vehicleNumber, int deletestatus);
    List<Vehicle> findByDeletestatus(int deletestatus);

    // Soft Delete query එක
    @Modifying
    @Transactional
    @Query("UPDATE Vehicle v SET v.deletestatus = 1 WHERE v.id = :id")
    void softDeleteVehicle(int id);
}