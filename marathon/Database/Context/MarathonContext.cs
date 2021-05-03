using Microsoft.EntityFrameworkCore;

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

    public DbSet<Models.Marathon> Marathons { get; set; }
  }
}
