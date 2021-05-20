﻿// <auto-generated />
using System;
using MarathonService.Database.Context;
using Microsoft.EntityFrameworkCore;
using Microsoft.EntityFrameworkCore.Infrastructure;
using Microsoft.EntityFrameworkCore.Storage.ValueConversion;

namespace marathon.Migrations
{
    [DbContext(typeof(MarathonContext))]
    partial class MarathonContextModelSnapshot : ModelSnapshot
    {
        protected override void BuildModel(ModelBuilder modelBuilder)
        {
#pragma warning disable 612, 618
            modelBuilder
                .HasAnnotation("Relational:MaxIdentifierLength", 64)
                .HasAnnotation("ProductVersion", "5.0.0");

            modelBuilder.Entity("MarathonService.Models.Marathon", b =>
                {
                    b.Property<long>("Id")
                        .ValueGeneratedOnAdd()
                        .HasColumnType("bigint");

                    b.Property<DateTime>("CreatedAt")
                        .HasColumnType("datetime(6)");

                    b.Property<long>("CreatorId")
                        .HasColumnType("bigint");

                    b.Property<float>("Goal")
                        .HasColumnType("float");

                    b.Property<DateTime>("StartDate")
                        .HasColumnType("datetime(6)");

                    b.Property<DateTime>("UpdatedAt")
                        .HasColumnType("datetime(6)");

                    b.HasKey("Id");

                    b.ToTable("Marathons");
                });

            modelBuilder.Entity("MarathonService.Models.MarathonParticipant", b =>
                {
                    b.Property<long>("MarathonId")
                        .HasColumnType("bigint");

                    b.Property<long>("ParticipantId")
                        .HasColumnType("bigint");

                    b.HasKey("MarathonId", "ParticipantId");

                    b.ToTable("MarathonParticipants");
                });

            modelBuilder.Entity("MarathonService.Models.MarathonParticipant", b =>
                {
                    b.HasOne("MarathonService.Models.Marathon", "Marathon")
                        .WithMany("Participants")
                        .HasForeignKey("MarathonId")
                        .HasConstraintName("MARATHON_PARTICIPANT_MARATHON_ID")
                        .OnDelete(DeleteBehavior.Cascade)
                        .IsRequired();

                    b.Navigation("Marathon");
                });

            modelBuilder.Entity("MarathonService.Models.Marathon", b =>
                {
                    b.Navigation("Participants");
                });
#pragma warning restore 612, 618
        }
    }
}
