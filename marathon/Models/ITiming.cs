
using System;

namespace MarathonService.Models
{
  public interface ITiming
  {
    DateTime CreatedAt { get; set; }
    DateTime UpdatedAt { get; set; }
  }
}
