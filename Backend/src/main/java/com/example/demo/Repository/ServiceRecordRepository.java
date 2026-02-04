package com.example.demo.Repository;

import java.util.List;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Modifying;
import org.springframework.data.jpa.repository.Query;
import org.springframework.stereotype.Repository;
import org.springframework.transaction.annotation.Transactional;
import com.example.demo.Entity.ServiceRecord;

@Repository
public interface ServiceRecordRepository extends JpaRepository<ServiceRecord, Integer> {

    List<ServiceRecord> findByDeletestatus(int deletestatus);

    @Modifying
    @Transactional
    @Query("UPDATE ServiceRecord s SET s.deletestatus = 1 WHERE s.id = :id")
    void softDeleteService(int id);
}