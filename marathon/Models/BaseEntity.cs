
using System;

namespace MarathonService.Models
{
  public abstract class BaseEntity : ITiming
  {
    public long Id { get; set; }
    public DateTime CreatedAt { get; set; }
    public DateTime UpdatedAt { get; set; }
  }
}
