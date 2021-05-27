using System;
using System.Linq;
using System.Threading;
using System.Threading.Tasks;
using MarathonService.Models;
using Microsoft.EntityFrameworkCore;
using Microsoft.EntityFrameworkCore.Metadata;

namespace MarathonService.Database.Context
{
  public partial class MarathonContext : DbContext
  {
    public MarathonContext()
    {
    }

    public MarathonContext(DbContextOptions<MarathonContext> options) : base(options)
    {
    }

    public DbSet<Marathon> Marathons { get; set; }
    public DbSet<MarathonParticipant> MarathonParticipants { get; set; }

    protected override void OnModelCreating(ModelBuilder modelBuilder)
    {
      modelBuilder.Entity<MarathonParticipant>(entity =>
      {
        entity.HasKey(mp => new { mp.MarathonId, mp.ParticipantId });

        entity.HasOne(d => d.Marathon)
          .WithMany(p => p.Participants)
          .HasForeignKey(d => d.MarathonId)
          .OnDelete(DeleteBehavior.Cascade)
          .HasConstraintName("MARATHON_PARTICIPANT_MARATHON_ID");
      });
    }

    public override int SaveChanges()
    {
      AddTimestamps();

      return base.SaveChanges();
    }

    public override async Task<int> SaveChangesAsync(CancellationToken cancellationToken = default)
    {
      AddTimestamps();

      return await base.SaveChangesAsync(cancellationToken);
    }

    private void AddTimestamps()
    {
      var entities = ChangeTracker.Entries()
        .Where(x => x.Entity is ITiming && (x.State == EntityState.Added || x.State == EntityState.Modified));

      foreach (var entity in entities)
      {
        var now = DateTime.UtcNow;

        if (entity.State == EntityState.Added)
        {
          ((ITiming)entity.Entity).CreatedAt = now;
        }

        ((ITiming)entity.Entity).UpdatedAt = now;
      }
    }
  }
}
